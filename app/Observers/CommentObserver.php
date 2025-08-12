<?php

namespace App\Observers;

use App\Models\Comment;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     */
    public function created(Comment $comment): void
    {
        // إذا كان التعليق معتمد (status = approved) وليس حذف مؤقت
        if ($comment->status === 'approved') {
            $this->incrementCounters($comment);
        }
    }

    /**
     * Handle the Comment "updated" event.
     */
    public function updated(Comment $comment): void
    {
        // إذا تم تغيير الحالة إلى approved
        if ($comment->isDirty('status')) {
            $oldStatus = $comment->getOriginal('status');
            $newStatus = $comment->status;
            
            // إذا تم الموافقة على تعليق كان معلق
            if ($oldStatus !== 'approved' && $newStatus === 'approved') {
                $this->incrementCounters($comment);
            }
            // إذا تم رفض تعليق كان معتمد
            elseif ($oldStatus === 'approved' && $newStatus !== 'approved') {
                $this->decrementCounters($comment);
            }
        }
    }

    /**
     * Handle the Comment "deleted" event.
     */
    public function deleted(Comment $comment): void
    {
        // إذا كان التعليق معتمد وتم حذفه
        if ($comment->status === 'approved') {
            $this->decrementCounters($comment);
        }
    }

    /**
     * Handle the Comment "restored" event.
     */
    public function restored(Comment $comment): void
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     */
    public function forceDeleted(Comment $comment): void
    {
        // عند الحذف النهائي
        if ($comment->status === 'approved') {
            $this->decrementCounters($comment);
        }
    }

    /**
     * زيادة العدادات عند إضافة تعليق معتمد
     */
    private function incrementCounters(Comment $comment): void
    {
        // تحديث عدد التعليقات في المنشور
        if ($comment->post) {
            $comment->post->increment('comments_count');
        }
        
        // إذا كان رد على تعليق آخر، زيادة عدد الردود
        if ($comment->parent_id && $comment->parent) {
            $comment->parent->increment('replies_count');
        }
        
        // تسجيل العملية
        \Log::info('Comment counter incremented', [
            'comment_id' => $comment->id,
            'post_id' => $comment->post_id,
            'is_anonymous' => $comment->is_anonymous,
            'is_reply' => !is_null($comment->parent_id)
        ]);
    }

    /**
     * تقليل العدادات عند حذف أو رفض تعليق
     */
    private function decrementCounters(Comment $comment): void
    {
        // تحديث عدد التعليقات في المنشور
        if ($comment->post) {
            $comment->post->decrement('comments_count');
        }
        
        // إذا كان رد على تعليق آخر، تقليل عدد الردود
        if ($comment->parent_id && $comment->parent) {
            $comment->parent->decrement('replies_count');
        }
        
        // تسجيل العملية
        \Log::info('Comment counter decremented', [
            'comment_id' => $comment->id,
            'post_id' => $comment->post_id,
            'is_anonymous' => $comment->is_anonymous,
            'is_reply' => !is_null($comment->parent_id)
        ]);
    }
}

@php
    $postTypeClass = match($post->hashtags) {
        default => str_contains($post->hashtags, 'نصب') || str_contains($post->hashtags, 'احتيال') ? 'warning' : 
                   (str_contains($post->hashtags, 'توصية') || str_contains($post->hashtags, 'مطعم') ? 'recommendation' : 
                   (str_contains($post->hashtags, 'تقنية') ? 'tech' : 'question'))
    };
    
    $iconClass = match($postTypeClass) {
        'warning' => 'warning-icon',
        'recommendation' => 'recommendation-icon', 
        'tech' => 'tech-icon',
        default => 'question-icon'
    };
    
    $icon = match($postTypeClass) {
        'warning' => 'bi-exclamation-triangle-fill',
        'recommendation' => 'bi-check-circle-fill',
        'tech' => 'bi-shield-exclamation', 
        default => 'bi-question-circle-fill'
    };
@endphp

<div class="post-card {{ $postTypeClass }}">
    <div class="post-header">
        <div class="post-type-icon {{ $iconClass }}">
            <i class="{{ $icon }}"></i>
        </div>
        <div class="flex-grow-1">
            <h3 class="post-title">
                <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                    @if($post->hashtags)
                        {{ Str::limit($post->content, 60) }}
                    @else
                        {{ Str::limit($post->content, 60) }}
                    @endif
                </a>
            </h3>
            @if($post->image_url)
                <div class="evidence-badge">📷 أدلة مرفقة</div>
            @endif
        </div>
    </div>
    
    <div class="post-content">
        {{ $post->content }}
    </div>
    
    @if($post->image_url)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $post->image_url) }}" 
                 alt="صورة المنشور" 
                 class="img-fluid rounded" 
                 style="max-height: 300px; width: 100%; object-fit: cover;">
        </div>
    @endif
    
    <div class="post-meta">
        <div class="d-flex gap-2 align-items-center">
            @if($post->type === 'anonymous')
                <span class="location-tag">🏠 مجهول</span>
            @else
                <span class="location-tag">👤 {{ $post->user->display_name ?? 'مستخدم' }}</span>
            @endif
            
            @if($post->category)
                @php
                    $categoriesMap = [
                        'complaint' => ['name' => 'شكوى', 'icon' => '⚠️', 'color' => 'warning'],
                        'experience' => ['name' => 'تجربة', 'icon' => '💭', 'color' => 'info'],
                        'recommendation' => ['name' => 'توصية', 'icon' => '👍', 'color' => 'success'],
                        'question' => ['name' => 'سؤال', 'icon' => '❓', 'color' => 'primary'],
                        'review' => ['name' => 'تقييم', 'icon' => '⭐', 'color' => 'secondary'],
                        'general' => ['name' => 'عام', 'icon' => '📝', 'color' => 'dark']
                    ];
                    $categoryInfo = $categoriesMap[$post->category] ?? ['name' => $post->category, 'icon' => '📝', 'color' => 'dark'];
                @endphp
                <span class="badge bg-{{ $categoryInfo['color'] }} me-2">
                    {{ $categoryInfo['icon'] }} {{ $categoryInfo['name'] }}
                </span>
            @endif
            
            @if($post->location)
                @php
                    $locationsMap = [
                        'baghdad' => 'بغداد', 'basra' => 'البصرة', 'erbil' => 'أربيل', 'mosul' => 'الموصل',
                        'najaf' => 'النجف', 'karbala' => 'كربلاء', 'sulaymaniyah' => 'السليمانية',
                        'kirkuk' => 'كركوك', 'diyala' => 'ديالى', 'anbar' => 'الأنبار',
                        'dhi_qar' => 'ذي قار', 'babylon' => 'بابل', 'wasit' => 'واسط',
                        'saladin' => 'صلاح الدين', 'qadisiyyah' => 'القادسية',
                        'maysan' => 'ميسان', 'muthanna' => 'المثنى', 'dohuk' => 'دهوك'
                    ];
                @endphp
                <span class="location-tag">📍 {{ $locationsMap[$post->location] ?? $post->location }}</span>
            @endif
            
            <span>منذ {{ $post->created_at->diffForHumans() }}</span>
        </div>
        
        <div class="post-stats">
            <div class="stat-item">
                <i class="bi bi-chat"></i>
                <span>{{ $post->comments_count }}</span>
            </div>
            
            @if($post->likes_count > 0)
                <div class="stat-item">
                    <i class="bi bi-hand-thumbs-up text-success"></i>
                    <span>{{ $post->likes_count }}</span>
                </div>
            @endif
            
            @if($post->views_count > 0)
                <div class="stat-item">
                    <i class="bi bi-eye text-info"></i>
                    <span>{{ $post->views_count }}</span>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Post Actions -->
    <div class="post-actions mt-3 pt-3 border-top">
        <div class="row g-2">
            <div class="col-auto">
                @auth
                    <form action="{{ route('posts.like', $post) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-hand-thumbs-up"></i>
                            {{ $post->likes_count > 0 ? $post->likes_count : '' }}
                        </button>
                    </form>
                @else
                    <form action="{{ route('posts.like.anonymous', $post) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-hand-thumbs-up"></i>
                            {{ $post->likes_count > 0 ? $post->likes_count : '' }}
                        </button>
                    </form>
                @endauth
            </div>
            
            <div class="col-auto">
                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-chat"></i>
                    تعليق ({{ $post->comments_count }})
                </a>
            </div>
            
            <div class="col-auto">
                <button type="button" 
                        class="btn btn-sm btn-outline-info" 
                        onclick="copyPostLink('{{ route('posts.show', $post) }}')"
                        title="انسخ رابط المنشور">
                    <i class="bi bi-share"></i>
                    مشاركة
                </button>
            </div>
            
            <div class="col-auto ms-auto">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <form action="{{ route('posts.save', $post) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-bookmark"></i> حفظ
                                    </button>
                                </form>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#reportModal{{ $post->id }}">
                                    <i class="bi bi-flag"></i> إبلاغ
                                </button>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Report Modal -->
                    <div class="modal fade" id="reportModal{{ $post->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">إبلاغ عن المنشور</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('posts.report', $post) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">سبب الإبلاغ</label>
                                            <textarea name="reason" class="form-control" rows="3" required 
                                                      placeholder="اذكر سبب الإبلاغ عن هذا المنشور..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-danger">إرسال الإبلاغ</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-three-dots"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

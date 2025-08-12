<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار النموذج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>اختبار إنشاء منشور</h2>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="/test-post" accept-charset="UTF-8">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">المحتوى فقط (اختبار بسيط)</label>
                        <textarea class="form-control" name="content" rows="4" required placeholder="اكتب رسالة الاختبار هنا...">{{ old('content') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">نشر</button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

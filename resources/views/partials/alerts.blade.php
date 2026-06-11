@if(session('success'))
    <div class="alert">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert error">
        <ul style="margin:0; padding-left:18px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

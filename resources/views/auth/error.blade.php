@if (session('error'))
    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ session('error') }}</strong>
            </span>
        </div>
    </div>
@endif

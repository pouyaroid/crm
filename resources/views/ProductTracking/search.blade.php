<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    جستجوی وضعیت محصول
                </div>
                <div class="card-body">
                    <form action="{{ route('product.tracking.search') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="product_code" class="form-label">کد محصول:</label>
                            <input type="text" name="product_code" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">جستجو</button>
                    </form>
                </div>
            </div>

            @if(isset($tracking))
                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        نتیجه جستجو
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>کد محصول:</strong> {{ $tracking->product_code }}</li>
                            <li class="list-group-item"><strong>وضعیت:</strong> {{ $tracking->status }}</li>
                            <li class="list-group-item"><strong>توضیحات:</strong> {{ $tracking->note ?? 'ندارد' }}</li>
                        </ul>
                    </div>
                </div>
                @elseif(isset($searched) && !$tracking)
                <div class="alert alert-danger mt-4">
                    محصولی با این کد یافت نشد!
                </div>
            @endif
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a new order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">
    <h2>Make a new order</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="need_by_date" class="form-label">Delivery date</label>
            <input type="date" id="need_by_date" name="need_by_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="product_type" class="form-label">Product type</label>
            <select id="product_type" name="product_type" class="form-control" required>
                <option value="">-- Select the type --</option>
                @foreach($productTypes as $type)
                    <option value="{{ $type }}">Type {{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div id="products-section" class="mb-3" style="display: none;">
            <label class="form-label">Availables products</label>
            <div id="product-list">
                @foreach($products as $product)
                    <div class="form-check product-item" data-type="{{ $product->type }}" style="display: none;">
                        <input class="form-check-input" type="checkbox" name="product_ids[]" value="{{ $product->id }}" id="product-{{ $product->id }}">
                        <label class="form-check-label" for="product-{{ $product->id }}">
                            {{ $product->name }}
                        </label>
                        <input type="number" name="quantities[{{ $product->id }}]" class="form-control mt-1" style="max-width: max-content;" placeholder="Quantité" min="1" disabled>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enter order</button>
    </form>
    <a href="{{ route('schedule.index') }}" class="btn btn-secondary mt-3">View Production Schedule</a>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const productTypeSelect = document.getElementById("product_type");
            const productSection = document.getElementById("products-section");
            const productItems = document.querySelectorAll(".product-item");

            productTypeSelect.addEventListener("change", function () {
                const selectedType = this.value;

                if (selectedType) {
                    productSection.style.display = "block";
                } else {
                    productSection.style.display = "none";
                }

                productItems.forEach(item => {
                    const checkbox = item.querySelector(".form-check-input");
                    const quantityInput = item.querySelector("input[type='number']");

                    if (item.getAttribute("data-type") === selectedType) {
                        item.style.display = "block";
                    } else {
                        item.style.display = "none";
                        checkbox.checked = false; 
                        quantityInput.disabled = true; 
                        quantityInput.value = ""; 
                    }
                });
            });
        });

        document.querySelectorAll(".form-check-input").forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                const quantityInput = this.closest(".product-item").querySelector("input[type='number']");
                quantityInput.disabled = !this.checked;
                if (!this.checked) {
                    quantityInput.value = "";
                }
            });
        });
        
    </script>

</body>
</html>

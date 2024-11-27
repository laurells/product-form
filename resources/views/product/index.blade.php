<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Product Information Form</h2>
        <form id="productForm">
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" required>
            </div>
            <div class="mb-3">
                <label for="quantityInStock" class="form-label">Quantity in Stock</label>
                <input type="number" class="form-control" id="quantityInStock" required>
            </div>
            <div class="mb-3">
                <label for="pricePerItem" class="form-label">Price per Item</label>
                <input type="number" class="form-control" id="pricePerItem" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <h3 class="mt-5">Product Data</h3>
        <table class="table table-bordered mt-3" id="productTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity in Stock</th>
                    <th>Price per Item</th>
                    <th>Datetime Submitted</th>
                    <th>Total Value</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr data-id="{{ $product->id }}">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->datetime }}</td>
                        <td>{{ $product->total_value }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm editBtn" onclick="editProduct({{ $product->id }})">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        // Handle form submission
        document.getElementById('productForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const name = document.getElementById('productName').value;
            const quantity = document.getElementById('quantityInStock').value;
            const price = document.getElementById('pricePerItem').value;

            axios.post('/products', { name, quantity, price })
                .then(response => {
                    const product = response.data;
                    alert('Product saved successfully');
                    location.reload(); // Refresh page to show the new data
                })
                .catch(error => {
                    console.error(error);
                    alert('There was an error saving the product');
                });
        });

    </script>
</body>
</html>

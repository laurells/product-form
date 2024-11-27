<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Form</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Axios for AJAX -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Product Information Form</h2>
        <!-- Form with Bootstrap classes -->
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

    <!-- Bootstrap JS and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Handle form submission using AJAX
        document.getElementById('productForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            const name = document.getElementById('productName').value;
            const quantity = document.getElementById('quantityInStock').value;
            const price = document.getElementById('pricePerItem').value;

            // Use Axios to submit the form data via POST request
            axios.post('/products', { name, quantity, price })
                .then(response => {
                    const product = response.data;
                    alert('Product saved successfully');
                    // Reload the page to show the new data
                    location.reload();
                })
                .catch(error => {
                    console.error(error);
                    alert('There was an error saving the product');
                });
        });

        // Edit functionality 
        function editProduct(id) {
            // Fetch product data using an AJAX GET request
            axios.get(`/products/${id}`)
                .then(response => {
                    const product = response.data;
                    
                    // Prefill the modal form with the product data
                    document.getElementById('editProductName').value = product.name;
                    document.getElementById('editQuantity').value = product.quantity;
                    document.getElementById('editPrice').value = product.price;
                    
                    // Show the modal
                    $('#editModal').modal('show');

                    // When the user saves the changes
                    document.getElementById('saveEditBtn').addEventListener('click', function() {
                        const updatedProduct = {
                            name: document.getElementById('editProductName').value,
                            quantity: document.getElementById('editQuantity').value,
                            price: document.getElementById('editPrice').value
                        };

                        // Send PUT request to update the product
                        axios.put(`/products/${id}`, updatedProduct)
                            .then(response => {
                                alert('Product updated successfully');
                                $('#editModal').modal('hide');  // Close the modal
                                location.reload();  // Reload the page or update the table dynamically
                            })
                            .catch(error => {
                                console.error(error);
                                alert('There was an error updating the product');
                            });
                    });
                })
                .catch(error => {
                    console.error(error);
                    alert('Product not found');
                });
        }
    </script>

    <!-- Modal for editing product -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form fields for editing -->
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editQuantity" class="form-label">Quantity in Stock</label>
                        <input type="number" class="form-control" id="editQuantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price per Item</label>
                        <input type="number" class="form-control" id="editPrice" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEditBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

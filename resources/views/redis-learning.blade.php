<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redis Learning</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container py-5">
        <h1 class="mb-4">🚀 Redis Learning</h1>


        <div class="card mb-3">
            <div class="card-header">Lesson 1: Store Data</div>
            <div class="card-body">
                <form id="storeForm">
                    <div class="mb-3">
                        <label for="storeKey" class="form-label">Key</label>
                        <input type="text" class="form-control" id="storeKey" required>
                    </div>
                    <div class="mb-3">
                        <label for="storeValue" class="form-label">Value</label>
                        <input type="text" class="form-control" id="storeValue" required>
                    </div>
                    <button type="submit" class="btn btn-success">Store</button>
                </form>
                <div id="storeResult" class="mt-3"></div>
            </div>
        </div>

        <!-- LESSON 2: Get data -->
        <div class="card mb-3">
            <div class="card-header">Lesson 2: Get Data</div>
            <div class="card-body">
                <form id="getForm">
                    <div class="mb-3">
                        <label for="getKey" class="form-label">Key</label>
                        <input type="text" class="form-control" id="getKey" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Get Value</button>
                </form>
                <div id="getResult" class="mt-3"></div>
            </div>
        </div>

        <!-- LESSON 3: Get all keys -->
        <div class="card mb-3">
            <div class="card-header">Lesson 3: Get All Keys</div>
            <div class="card-body">
                <button id="allKeysBtn" class="btn btn-info">Show All Keys</button>
                <div id="allKeysResult" class="mt-3"></div>
            </div>
        </div>

        <!-- LESSON 4: Delete key -->
        <div class="card mb-3">
            <div class="card-header">Lesson 4: Delete Key</div>
            <div class="card-body">
                <form id="deleteForm">
                    <div class="mb-3">
                        <label for="deleteKey" class="form-label">Key</label>
                        <input type="text" class="form-control" id="deleteKey" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete Key</button>
                </form>
                <div id="deleteResult" class="mt-3"></div>
            </div>
        </div>

        <!-- LESSON 5: Check if key exists -->
        <div class="card mb-3">
            <div class="card-header">Lesson 5: Check Key Existence</div>
            <div class="card-body">
                <form id="existsForm">
                    <div class="mb-3">
                        <label for="existsKey" class="form-label">Key</label>
                        <input type="text" class="form-control" id="existsKey" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Check Exists</button>
                </form>
                <div id="existsResult" class="mt-3"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute(
            'content');

        // Store
        document.getElementById('storeForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const key = document.getElementById('storeKey').value;
            const value = document.getElementById('storeValue').value;
            try {
                const res = await axios.post('/learn-redis/store', {
                    key,
                    value
                });
                document.getElementById('storeResult').innerHTML =
                    `<div class="alert alert-success">${res.data.message}</div>`;
            } catch (err) {
                document.getElementById('storeResult').innerHTML =
                    `<div class="alert alert-danger">Error storing key</div>`;
            }
        });

        // Get
        document.getElementById('getForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const key = document.getElementById('getKey').value;
            try {
                const res = await axios.get(`/learn-redis/get/${key}`);
                document.getElementById('getResult').innerHTML =
                    `<div class="alert alert-info">${res.data.key} = ${res.data.value}</div>`;
            } catch (err) {
                document.getElementById('getResult').innerHTML =
                    `<div class="alert alert-danger">Key not found</div>`;
            }
        });

        // Get all keys
        document.getElementById('allKeysBtn').addEventListener('click', async () => {
            try {
                const res = await axios.get('/learn-redis/all');
                let html = `<p>Total keys: ${res.data.count}</p><ul>`;
                for (let key in res.data.data) {
                    html += `<li>${key} = ${res.data.data[key]}</li>`;
                }
                html += '</ul>';
                document.getElementById('allKeysResult').innerHTML = html;
            } catch (err) {
                document.getElementById('allKeysResult').innerHTML =
                    `<div class="alert alert-danger">Error fetching keys</div>`;
            }
        });

        // Delete key
        document.getElementById('deleteForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const key = document.getElementById('deleteKey').value;
            try {
                const res = await axios.delete(`/learn-redis/delete/${key}`);
                document.getElementById('deleteResult').innerHTML =
                    `<div class="alert alert-success">${res.data.message}</div>`;
            } catch (err) {
                document.getElementById('deleteResult').innerHTML =
                    `<div class="alert alert-danger">Error deleting key</div>`;
            }
        });

        // Check exists
        document.getElementById('existsForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const key = document.getElementById('existsKey').value;
            try {
                const res = await axios.get(`/learn-redis/exists/${key}`);
                const type = res.data.exists ? 'success' : 'danger';
                document.getElementById('existsResult').innerHTML =
                    `<div class="alert alert-${type}">${res.data.message}</div>`;
            } catch (err) {
                document.getElementById('existsResult').innerHTML =
                    `<div class="alert alert-danger">Error checking key</div>`;
            }
        });
    </script>
</body>

</html>

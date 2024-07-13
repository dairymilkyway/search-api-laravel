<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        /* Custom styling for the suggestion bubbles */
        .suggestion-bubble {
            transition: background-color 0.2s, transform 0.2s;
        }

        .suggestion-bubble:hover {
            background-color: #3182ce;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-2xl mx-auto p-6">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Search Products</h1>
            <p class="text-center text-gray-600 mb-8">Find products by typing in the search box below</p>
            <input type="text" id="search" placeholder="Search for products..." class="w-full p-4 border border-gray-300 rounded-lg mb-6 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <div id="results" class="flex flex-wrap -m-1"></div>
        </div>
    </div>
    <script>
        document.getElementById('search').addEventListener('input', function() {
            let query = this.value;
            console.log('Query:', query);  // Log the current input query

            fetch(`/api/search?query=${query}`)
                .then(response => {
                    console.log('Response status:', response.status);  // Log the response status
                    return response.json();
                })
                .then(data => {
                    console.log('Data:', data);  // Log the fetched data

                    let results = document.getElementById('results');
                    results.innerHTML = '';  // Clear previous results

                    if (data.length === 0) {
                        let noResults = document.createElement('div');
                        noResults.className = 'w-full p-4 text-gray-500';
                        noResults.textContent = 'No results found';
                        results.appendChild(noResults);
                    } else {
                        data.forEach(product => {
                            let bubble = document.createElement('div');
                            bubble.className = 'suggestion-bubble m-1 px-4 py-2 bg-blue-100 text-blue-800 rounded-full cursor-pointer hover:bg-blue-200 transition duration-200';
                            bubble.textContent = product.name;
                            bubble.addEventListener('click', () => {
                                document.getElementById('search').value = product.name;
                                results.innerHTML = '';
                            });
                            results.appendChild(bubble);
                        });
                    }
                });
        });
    </script>
</body>
</html>

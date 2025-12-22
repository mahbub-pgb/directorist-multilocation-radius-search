
<body>
    <div class="container">
        <div class="header">
            <h1>🗺️ Multi Location Google Maps</h1>
            <!-- <p>Test with sample locations - Click markers to see details</p> -->
        </div>

        <div class="controls">
            <button onclick="fitAllMarkers()">📍 Show All Locations</button>
            <button onclick="resetZoom()">🔄 Reset View</button>
        </div>

        <div id="map">
            <div class="loading">Loading map...</div>
        </div>

        <div class="location-list">
            <h3>📋 All Locations</h3>
            <div id="locationsList"></div>
        </div>
    </div>

    <script>
        
    </script>

    <!-- Replace YOUR_API_KEY with your actual Google Maps API key -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwxELCisw4mYqSv_cBfgOahfrPFjjQLLo&callback=initMap"
        onerror="alert('Failed to load Google Maps. Please check your internet connection and API key.')">
    </script>
</body>
</html>
// TEST DATA - Replace this with your actual data later
        const testLocations = MultiLocationMapData.locations;
        let map;
        let markers = [];
        let infoWindows = [];
        let bounds;
        let trafficLayer;

        // Initialize map
        function initMap() {
            console.log('Initializing map with', testLocations.length, 'locations');

            // Map center (Dhaka, Bangladesh)
            const center = { lat: 23.8103, lng: 90.4125 };

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: center,
                mapTypeId: 'roadmap',
                mapTypeControl: true,
                streetViewControl: true,
                fullscreenControl: true,
                zoomControl: true,
                styles: [
                    {
                        featureType: 'poi.business',
                        stylers: [{ visibility: 'off' }]
                    }
                ]
            });

            bounds = new google.maps.LatLngBounds();
            trafficLayer = new google.maps.TrafficLayer();

            // Add all markers
            testLocations.forEach((location, index) => {
                addMarker(location, index);
            });

            // Fit bounds to show all markers
            if (testLocations.length > 0) {
                map.fitBounds(bounds);
            }

            // Populate location list
            populateLocationList();
        }

        // Add marker to map
        function addMarker(location, index) {
            const position = { 
                lat: parseFloat(location.lat), 
                lng: parseFloat(location.lng) 
            };

            // Custom marker icon
            const marker = new google.maps.Marker({
                position: position,
                map: map,
                title: location.title,
                animation: google.maps.Animation.DROP,
                label: {
                    text: (index + 1).toString(),
                    color: 'white',
                    fontWeight: 'bold',
                    fontSize: '14px'
                },
                icon: {
                    path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
                    fillColor: '#FF5722',
                    fillOpacity: 1,
                    strokeColor: 'white',
                    strokeWeight: 2,
                    scale: 2.5,
                    anchor: new google.maps.Point(12, 24)
                }
            });

            // Info window content
            const infoContent = `
                <div class="info-window">
                    <img src="${location.image}" alt="${location.title}">
                    <h3>${location.title}</h3>
                    <p><span class="icon">📍</span> ${location.address}</p>
                    <p><span class="icon">📞</span> ${location.phone}</p>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${location.lat},${location.lng}" target="_blank">
                        Get Directions →
                    </a>
                </div>
            `;

            const infoWindow = new google.maps.InfoWindow({
                content: infoContent,
                maxWidth: 300
            });

            // Click event
            marker.addListener('click', () => {
                closeAllInfoWindows();
                infoWindow.open(map, marker);
                
                // Bounce animation
                marker.setAnimation(google.maps.Animation.BOUNCE);
                setTimeout(() => marker.setAnimation(null), 750);

                // Center map on marker
                map.panTo(position);
            });

            markers.push(marker);
            infoWindows.push(infoWindow);
            bounds.extend(position);
        }

        // Close all info windows
        function closeAllInfoWindows() {
            infoWindows.forEach(iw => iw.close());
        }

        // Fit all markers in view
        function fitAllMarkers() {
            if (markers.length > 0) {
                const bounds = new google.maps.LatLngBounds();
                markers.forEach(marker => {
                    bounds.extend(marker.getPosition());
                });
                map.fitBounds(bounds);
            }
        }

        // Reset zoom
        function resetZoom() {
            map.setZoom(12);
            map.setCenter({ lat: 23.8103, lng: 90.4125 });
            closeAllInfoWindows();
        }

        // Toggle traffic layer
        function toggleTraffic() {
            if (trafficLayer.getMap()) {
                trafficLayer.setMap(null);
            } else {
                trafficLayer.setMap(map);
            }
        }

        // Change map type
        function changeMapType(type) {
            map.setMapTypeId(type);
        }

        // Populate location list
        function populateLocationList() {
            const listContainer = document.getElementById('locationsList');
            listContainer.innerHTML = '';

            testLocations.forEach((location, index) => {
                const item = document.createElement('div');
                item.className = 'location-item';
                item.innerHTML = `
                    <div class="location-number">${index + 1}</div>
                    <div class="location-details">
                        <strong>${location.title}</strong>
                        <small>${location.address}</small>
                        <span class="location-phone">📞 ${location.phone}</span>
                    </div>
                `;
                
                item.addEventListener('click', () => {
                    const marker = markers[index];
                    const infoWindow = infoWindows[index];
                    
                    closeAllInfoWindows();
                    infoWindow.open(map, marker);
                    map.panTo(marker.getPosition());
                    map.setZoom(15);
                    
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                    setTimeout(() => marker.setAnimation(null), 750);
                });

                listContainer.appendChild(item);
            });
        }

        // Handle map load errors
        window.gm_authFailure = function() {
            alert('Google Maps API authentication failed. Please check your API key.');
        };

jQuery(function ($) {

    function copyText(text, callback) {

        /* Modern API */
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(callback);
            return;
        }

        /* Fallback */
        const $temp = $('<textarea>');
        $('body').append($temp);
        $temp.val(text).select();
        document.execCommand('copy');
        $temp.remove();
        callback();
    }

    function ensureCopyButton() {

        // alert( 'tset' );

        $('.directorist-form-address-field input#address').each(function () {

            const $input = $(this);

            /* If already wrapped, skip */
            if ($input.closest('.address-copy-wrapper').length) {
                return;
            }

            /* Wrap input */
            $input.wrap('<div class="address-copy-wrapper"></div>');

            /* Create button */
            const $btn = $('<button>', {
                type: 'button',
                class: 'copy-address-btn',
                html: '📋',
                title: 'Copy address'
            });

            /* Create message */
            const $msg = $('<span>', {
                class: 'copy-message',
                text: 'Copied!'
            });

            /* Insert */
            $input.after($btn);
            $input.closest('.directorist-form-address-field').append($msg);

            /* Click handler (bound once) */
            $btn.on('click', function () {
                const value = $input.val();
                if (!value) return;

                copyText(value, function () {
                    $msg.stop(true, true).fadeIn(150);
                    setTimeout(() => $msg.fadeOut(300), 1500);
                });
            });

        });
    }

    /* 🔁 Watch every 500ms */
    setInterval(ensureCopyButton, 500);

});

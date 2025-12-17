jQuery(function ($) {

    function isGooglePlacesLoaded() {
        return (typeof google !== "undefined" && google.maps && google.maps.places);
    }

    function initAutocompleteForInput(input) {
        if (!input || !isGooglePlacesLoaded()) return;

        const autocomplete = new google.maps.places.Autocomplete(input, { types: ["geocode"] });

        autocomplete.addListener("place_changed", function () {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            const $wrapper = $(input).closest(".address_item");
            $wrapper.find(".google_addresses_lat").val(place.geometry.location.lat());
            $wrapper.find(".google_addresses_lng").val(place.geometry.location.lng());

            generateJson();
        });
    }

    function initAutocomplete() {
        $(".google_addresses").each(function () {
            initAutocompleteForInput(this);
        });
    }

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function generateAddressField() {
        const uniqueId = getRandomInt(100000, 999999);
        const newField = `
        <div class="address_item" data-id="${uniqueId}">
            <div class="address_line">
                <label>Address:</label>
                <input type="text" class="google_addresses" name="addresses[]" placeholder="Enter address">
            </div>
            <div class="branch_line">
                <div class="branch_label_wrapper">
                    <label>Optional Branch Label:</label>
                    <input type="text" name="branch_label[]" class="branch_label" placeholder="Enter branch label">
                </div>
                <div class="branch_phone_wrapper">
                    <label>Optional Phone:</label>
                    <input type="text" name="branch_phone[]" class="branch_phone" placeholder="Enter phone number">
                </div>
            </div>
            <input type="hidden" class="google_addresses_lat" name="latitude[]" value="">
            <input type="hidden" class="google_addresses_lng" name="longitude[]" value="">
            <button type="button" class="remove_address_btn">X</button>
        </div>
        `;
        $(".address_field_holder").append(newField);
        initAutocompleteForInput($(".address_field_holder .address_item").last().find(".google_addresses")[0]);
    }

    function generateJson() {
        const addresses = [];
        $(".address_item").each(function () {
            const addr = $(this).find(".google_addresses").val() || "";
            const lat = $(this).find(".google_addresses_lat").val() || "";
            const lng = $(this).find(".google_addresses_lng").val() || "";
            const label = $(this).find(".branch_label").val() || "";
            const phone = $(this).find(".branch_phone").val() || "";

            if (addr.trim() !== "") {
                addresses.push({ address: addr, latitude: lat, longitude: lng, branch_label: label, phone: phone });
            }
        });

        $("input.google_addresses_json").val(JSON.stringify(addresses));
    }

    // Add address
    $(document).on("click", ".add_address_btn", function () {
        generateAddressField();
    });

    // Remove address
    $(document).on("click", ".remove_address_btn", function () {
        $(this).closest(".address_item").slideUp(200, function () {
            $(this).remove();
            generateJson();
        });
    });

    // Update JSON on input change
    $(document).on("input", ".google_addresses, .branch_label, .branch_phone", function () {
        generateJson();
    });

    // Initialize autocomplete on page load
    $(window).on("load", function () {
        if (isGooglePlacesLoaded()) {
            setTimeout(initAutocomplete, 1000);
        }
    });

});

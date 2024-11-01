<?php
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showLocation, handleLocationError);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showLocation(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // Tambahkan input tersembunyi untuk menyimpan lokasi
        var locationInput = document.createElement("input");
        locationInput.setAttribute("type", "hidden");
        locationInput.setAttribute("name", "lokasi");
        locationInput.setAttribute("value", latitude + "," + longitude);

        // Sisipkan input ke dalam form
        document.getElementById("presensiForm").appendChild(locationInput);

        alert("Lokasi berhasil diambil: " + latitude + ", " + longitude);
    }

    function handleLocationError(error) {
        // ... (Penanganan error jika diperlukan)
    }
?>
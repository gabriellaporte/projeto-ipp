@extends('layouts/contentNavbarLayout')

@section('title', 'Mapa de Endereços')


@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Pesquisar / Endereços /</span> Mapa
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card py-4" id="mapWrapper" style="height: 70vh">

            </div>
        </div>
    </div>

@endsection

@section('page-script')
    <script>

        let map = L.map('mapWrapper').setView([-22.90799215, -43.18133397993144], 16);

        L.tileLayer('https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=xinj6wTWg04tHLy3VyQd',{
            tileSize: 512,
            zoomOffset: -1,
            minZoom: 1,
            crossOrigin: true
        }).addTo(map);

        $(document).ready( function () {
            $.get("/api/addresses/").done(data => {

                data.forEach(function (address) {
                    $.get('https://nominatim.openstreetmap.org/search?format=json&q=' + address.address + ', ' + address.house_number + ', ' + address.area + ', ' + address.city + ', ' + address.state, (response) => {
                        let users = JSON.parse("[" + address.users + "]");
                        let usersNames = address.users_names.split(',');

                        let addressInfo = address.address_complement == null ? address.address + ', ' + address.house_number + ', ' + address.area + ', ' + address.city : address.address + ', ' + address.house_number + ', ' + address.address_complement + ', ' + address.area + ', ' + address.city;
                        addressInfo += '<br><br><strong>Moradores:</strong><br><br>';

                        users.forEach((user, index) => {
                            addressInfo += usersNames[index] + '<br>';
                        })

                        let marker = L.marker([response[0].lat, response[0].lon]).addTo(map).bindPopup(addressInfo);
                    });
                });
            }).done( () => {
                setTimeout(function() {
                    map.invalidateSize();
                }, 1200);
            }).fail( () => {
                $("#mapWrapper").html("<p class='text-center mb-0'>Houve um erro com o banco de dados. Tente novamente.</p>");
            })
        });

    </script>
@endsection

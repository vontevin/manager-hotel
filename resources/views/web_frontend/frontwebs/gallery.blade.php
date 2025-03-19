<!-- Gallery Section -->
<div class="w3-services py-5">
    <div class="container py-lg-4">
        <div class="title-content text-center mb-lg-5 mb-4">
            <h6 class="sub-title title-with-lines">Explore Our Gallery</h6>
            <h3 class="hny-title">Hotel Room Gallery</h3>
        </div>
        <div class="row w3-services-grids">
            @foreach ($galleries as $gallery)
                <div class="col-lg-4 col-md-6 causes-grid">
                    <div class="causes-grid-info" style="background-color: #ecdfd794">
                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->name }}" class="img-fluid zoom-img" onclick="openModal('{{ asset('storage/' . $gallery->image) }}')" role="button" aria-label="View larger image of {{ $gallery->name }}">
                        <a href="{{url('room')}}" class="cause-title-wrap">
                            <h4 class="cause-title">{{ Str::limit ($gallery->name,21) }}</h4>
                        </a>
                        <div class="amenities-icons">
                            <i class="fas fa-wifi" aria-hidden="true" title="WiFi"></i>
                            <i class="fas fa-swimmer" style="margin-left: 8px" aria-hidden="true" title="Swimming Pool"></i>
                            <i class="fas fa-bed" style="margin-left: 8px" aria-hidden="true" title="Bedroom"></i>
                        </div>
                        <br/>
                        <p class="card-text mb-0">{{ Str::limit($gallery->description, 60) }}</p>
                        <a href="{{ url('room/') }}" class="btn btn-style btn-primary mt-4">Details</a>
                        <a href="{{ url('room/') }}" class="btn btn-style mt-4" style="background: rgb(192, 192, 86); color: black;">
                        @php
                            $currency = session('currency', 'USD'); // Default to USD if no currency is set
                            $exchangeRate = 4100; // Example exchange rate
                        @endphp
                        @if ($currency == 'KHR')
                            {{ number_format($gallery->price * $exchangeRate) }} ៛
                        @else
                            ${{ $gallery->price }}
                        @endif</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>


<!-- Modal structure (place this outside the loop) -->
<div id="imageModal" class="image-modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>
<script>
    function openModal(imageSrc) {
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("modalImage");
        modal.style.display = "block";
        modalImg.src = imageSrc;
    }

    function closeModal() {
        var modal = document.getElementById("imageModal");
        modal.style.display = "none";
    }

</script>

<!-- About Page -->
<section class="w3l-content-3 card">
    <div class="content-3-main py-5">
        <div class="container py-lg-5">
            <div class="content-info-in row">
                <div class="col-lg-6">
                    <img src="{{ asset('hotel/images/room17.jpg') }}" alt="{{ trans('menu.image_alt') }}" class="img-fluid">
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5 about-right-faq align-self pl-lg-5">
                    <div class="title-content text-left mb-2">
                        <h6 class="sub-title title-with-lines">{{ trans('menu.sub_title') }}</h6>
                        <h6 class="hny-title">{{ trans('menu.main_title') }}</h6>
                    </div>
                    <p class="mt-3">
                        {{ trans('menu.welcome_message') }}
                        <a href="https://maps.app.goo.gl/w3xuqLvvdPfe1zpF7" style="color: #e90000; font-size: 20px;">
                            {{ trans('menu.hotel_name') }}
                        </a>
                        {{ trans('menu.descriptions') }}
                    </p>
                    <a href="{{ url('room') }}" class="btn btn-style btn-primary mt-md-5 mt-4">
                        {{ trans('menu.read_more') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Inline CSS for Buttons -->
<style>
.location-container {
    display: flex;
    align-items: center;
    gap: 8px;
}

.location-container i {
    font-size: 18px;
    color: #333;
}

.location-container input {
    width: 100%;
    padding-left: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
}

/* General Container */
.passenger-counter-container {
    position: relative;
    width: 300px;
    font-family: Arial, sans-serif;
}

.passenger-btn {
    width: 100%;
    padding: 10px 15px;
    background: #f7f7f7;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    text-align: left;
    display: flex;
    justify-content: space-between;
}

.passenger-dropdown {
    display: none;
    position: absolute;
    width: 100%;
    background: white;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    padding: 10px;
    z-index: 1000;
}

.counter-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.counter-controls {
    display: flex;
    align-items: center;
}

.increment-btn, .decrement-btn {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background-color: #f0f0f0;
    text-align: center;
    font-size: 18px;
    cursor: pointer;
    border-radius: 50%;
}

.increment-btn:hover, .decrement-btn:hover {
    background-color: #ddd;
}

input[readonly] {
    width: 30px;
    border: none;
    text-align: center;
    font-size: 16px;
    margin: 0 5px;
}

.done-btn {
    width: 100%;
    padding: 8px;
    background-color: #0062cc;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.done-btn:hover {
    background-color: #005bb5;
}

</style>

<script>
   document.addEventListener("DOMContentLoaded", () => {
    const passengerBtn = document.getElementById("passenger-selector-btn");
    const dropdown = document.getElementById("passenger-dropdown");
    const passengerSummary = document.getElementById("passenger-summary");

    // Counter elements
    const adultsCount = document.getElementById("adults-count");
    const childrenCount = document.getElementById("children-count");
    const roomsCount = document.getElementById("rooms-count");

    // Toggle Dropdown
    passengerBtn.addEventListener("click", (event) => {
        // Prevent default form submission
        event.preventDefault();
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    });

    // Update Summary Text
    const updateSummary = () => {
        const adults = parseInt(adultsCount.value, 10);
        const children = parseInt(childrenCount.value, 10);
        const rooms = parseInt(roomsCount.value, 10);

        passengerSummary.textContent = `${adults} Adult${adults !== 1 ? "s" : ""} · ${children} Child${children !== 1 ? "ren" : ""} · ${rooms} Room${rooms !== 1 ? "s" : ""}`;
    };

    // Increment & Decrement Functions
    const updateCount = (buttonId, countElement, increment) => {
        document.getElementById(buttonId).addEventListener("click", (event) => {
            event.preventDefault(); // Prevent default button behavior
            let value = parseInt(countElement.value, 10);
            if (increment) {
                value += 1;
            } else if (value > 0) {
                value -= 1;
            }
            countElement.value = value;
            updateSummary();
        });
    };

    // Adults Counter
    updateCount("adults-increment", adultsCount, true);
    updateCount("adults-decrement", adultsCount, false);

    // Children Counter
    updateCount("children-increment", childrenCount, true);
    updateCount("children-decrement", childrenCount, false);

    // Rooms Counter
    updateCount("rooms-increment", roomsCount, true);
    updateCount("rooms-decrement", roomsCount, false);

    // Hide dropdown when clicking outside
    document.addEventListener("click", (e) => {
        if (!passengerBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = "none";
        }
    });
});
</script>

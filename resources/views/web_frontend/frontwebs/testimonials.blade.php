<div class="testimon">
    <h2 class="section-title title-with-lin">What Our Clients Say</h2>
    <div class="slider-conta">
        <div class="testimon-container">
            @foreach ($clients as $client)
                <div class="testimonian">
                    <div class="testimonian-author">
                        <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}" class="author-img">
                        <div class="author-info">
                            <h3 class="author-name">{{ $client->name }}</h3>
                            <p class="author-role">{{ $client->skill }}</p>
                        </div>
                    </div>
                    <p class="testimonian-text">
                        {{ $client->description }}
                    </p>
                </div>
            @endforeach
        </div>
        <!-- Slider Controls -->
        <button class="slider-btn prev-btn">&lt;</button>
        <button class="slider-btn next-btn">&gt;</button>
    </div>
</div>
<style>
    .testimon {
    text-align: center;
    padding: 50px 20px;
    background-color: #f9f9f9;
}

.section-title {
    font-size: 28px;
    margin-bottom: 20px;
    position: relative;
    display: inline-block;
}

.title-with-lin::before,
.title-with-lin::after {
    content: "";
    display: block;
    width: 50px;
    height: 2px;
    background-color: #333;
    position: absolute;
    top: 50%;
}

.title-with-lin::before {
    left: -60px;
}

.title-with-lin::after {
    right: -60px;
}

.slider-conta {
    position: relative;
    overflow: hidden;
    max-width: 600px;
    margin: 0 auto;
}

.testimon-container {
    display: flex;
    transition: transform 0.5s ease-in-out;
    width: 100%;
}

.testimonian {
    flex: 0 0 100%;
    box-sizing: border-box;
    background: white;
    padding: 20px;
    margin: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.testimonian-author {
    /* display: flex; */
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.author-img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #333;
}

.author-info {
    align-items: center;
}

.author-name {
    font-size: 18px;
    font-weight: bold;
    margin: 0;
}

.author-role {
    font-size: 14px;
    color: #777;
    margin: 0;
}

.testimonian-text {
    font-size: 16px;
    color: #555;
    line-height: 1.5;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    border-radius: 50%;
    font-size: 18px;
    width: 40px;
    height: 40px;
}

.slider-btn:hover {
    background-color: rgba(0, 0, 0, 0.7);
}

.prev-btn {
    left: 10px;
}

.next-btn {
    right: 10px;
}

</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.querySelector('.testimon-container');
        const slides = document.querySelectorAll('.testimonian');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');

        let currentIndex = 0;

        const updateSlider = () => {
            const offset = -currentIndex * 100;
            container.style.transform = `translateX(${offset}%)`;
        };

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % slides.length;
            updateSlider();
        });

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlider();
        });
    });

</script>
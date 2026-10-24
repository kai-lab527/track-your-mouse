<?php
$imageDir = 'img/';
$images = glob($imageDir . '[0-9]*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

if (empty($images)) {
    $images = ['https://via.placeholder.com/600x800?text=Add+Images+to+img+folder'];
}

natsort($images);
$images = array_values($images);
$totalImages = count($images);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>//</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            height: 100vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: crosshair;
        }

        .image-container {
            position: relative;
            width: 400px;
            height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            border: 2px solid #222;
            background-color: #1a1a1a;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.1s linear;
            pointer-events: none;
            user-select: none;
        }

        .image-container img.active {
            opacity: 1;
        }

        @media (max-width: 500px) {
            .image-container {
                width: 320px;
                height: 420px;
            }
        }
    </style>
</head>
<body>

    <div class="image-container" id="imageContainer">
        <?php foreach ($images as $index => $img): ?>
            <img src="<?php echo htmlspecialchars($img); ?>" 
                 alt="Angle <?php echo $index + 1; ?>" 
                 class="track-img <?php echo $index === 0 ? 'active' : ''; ?>"
                 data-index="<?php echo $index; ?>">
        <?php endforeach; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const images = document.querySelectorAll('.track-img');
            const totalImages = images.length;
            let currentIndex = 0;

            if (totalImages <= 1) return;

            const IMG_CENTER = 0;
            const IMG_DOWN_SOFT = 1;
            const IMG_DOWN = 2;
            const IMG_RIGHT = 3;
            const IMG_UP = 4;
            const IMG_LEFT = 5;
            const IMG_UP_LEFT = 6;
            const IMG_RIGHT_SOFT = 7;
            const IMG_UP_RIGHT = 8;
            const IMG_UP_SOFT = 9;

            const SECTORS = [
                [IMG_RIGHT_SOFT, IMG_RIGHT],
                [IMG_DOWN_SOFT, IMG_DOWN],
                [IMG_DOWN_SOFT, IMG_DOWN],
                [IMG_DOWN, IMG_LEFT],
                [IMG_LEFT],
                [IMG_UP_LEFT],
                [IMG_UP_SOFT, IMG_UP],
                [IMG_UP_RIGHT]
            ];

            const handleMouseMove = (e) => {
                const centerX = window.innerWidth / 2;
                const centerY = window.innerHeight / 2;

                const dx = e.clientX - centerX;
                const dy = e.clientY - centerY;
                const distance = Math.sqrt(dx * dx + dy * dy);

                let targetIndex = IMG_CENTER;

                if (distance > 60) {
                    const deg = Math.atan2(dy, dx) * 180 / Math.PI;

                    const sector = ((Math.round(deg / 45) % 8) + 8) % 8;

                    const options = SECTORS[sector].filter(i => i < totalImages);

                    if (options.length) {
                        const far = Math.min(window.innerWidth, window.innerHeight) / 2;
                        const t = Math.min(0.999, (distance - 60) / Math.max(1, far - 60));
                        targetIndex = options[Math.floor(t * options.length)];
                    }
                }

                if (targetIndex >= totalImages) {
                    targetIndex = IMG_CENTER;
                }

                if (targetIndex !== currentIndex) {
                    images[currentIndex].classList.remove('active');
                    images[targetIndex].classList.add('active');
                    currentIndex = targetIndex;
                }
            };

            window.addEventListener('mousemove', handleMouseMove);
        });
    </script>
</body>
</html>

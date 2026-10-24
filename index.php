<?php
// Get all images from the img folder (numbered files only: 1.jpg, 2.jpg, 3.jpg ...)
$imageDir = 'img/';
$images = glob($imageDir . '[0-9]*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);

// Fallback if the folder is empty
if (empty($images)) {
    $images = ['https://via.placeholder.com/600x800?text=Add+Images+to+img+folder'];
}

// Sort images naturally so they follow a specific order (1, 2, 3...)
natsort($images);
$images = array_values($images);
$totalImages = count($images);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2ez4KAI</title>
    <style>
        /* Reset and Base Styles */
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

        /* Image Container */
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
            transition: opacity 0.1s linear; /* Fast smooth swap */
            pointer-events: none;
            user-select: none;
        }

        .image-container img.active {
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 500px) {
            .image-container {
                width: 320px;
                height: 420px;
            }
        }
    </style>
</head>
<body>

    <!-- Main Image Tracker -->
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

            // Image indexes follow the natural filename order: 1.jpg, 2.jpg, ...
            const IMG_CENTER = 0; // 1.jpg: centered
            const IMG_DOWN_SOFT = 1; // 2.jpg: slight downward gaze
            const IMG_DOWN = 2; // 3.jpg: stronger downward gaze
            const IMG_RIGHT = 3; // 4.jpg: right
            const IMG_UP = 4; // 5.jpg: up
            const IMG_LEFT = 5; // 6.jpg: left
            const IMG_UP_LEFT = 6; // 7.jpg: up-left
            const IMG_RIGHT_SOFT = 7; // 8.jpg: slight rightward gaze
            const IMG_UP_RIGHT = 8; // 9.jpg: up-right
            const IMG_UP_SOFT = 9; // 10.jpg: slight upward gaze

            // Sectors are ordered clockwise from right. Each list goes from a
            // subtler available pose to a stronger one as the cursor moves farther.
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
                // Get the exact center of the window
                const centerX = window.innerWidth / 2;
                const centerY = window.innerHeight / 2;

                // Calculate distance from center
                const dx = e.clientX - centerX;
                const dy = e.clientY - centerY;
                const distance = Math.sqrt(dx * dx + dy * dy);

                let targetIndex = IMG_CENTER;

                // If the mouse is far enough from the center (deadzone)
                if (distance > 60) {
                    // Calculate angle in degrees
                    // Right: 0, Down: 90, Left: 180 or -180, Up: -90
                    const deg = Math.atan2(dy, dx) * 180 / Math.PI;

                    // Split into 8 sectors of 45 degrees each
                    const sector = ((Math.round(deg / 45) % 8) + 8) % 8;

                    // Only use pictures that actually exist in the folder
                    const options = SECTORS[sector].filter(i => i < totalImages);

                    if (options.length) {
                        // Close to the center = small look, near the edge = big look
                        const far = Math.min(window.innerWidth, window.innerHeight) / 2;
                        const t = Math.min(0.999, (distance - 60) / Math.max(1, far - 60));
                        targetIndex = options[Math.floor(t * options.length)];
                    }
                }

                // Ensure we don't try to load an image that doesn't exist
                if (targetIndex >= totalImages) {
                    targetIndex = IMG_CENTER;
                }

                // Swap the image
                if (targetIndex !== currentIndex) {
                    images[currentIndex].classList.remove('active');
                    images[targetIndex].classList.add('active');
                    currentIndex = targetIndex;
                }
            };

            // Listen to the whole window
            window.addEventListener('mousemove', handleMouseMove);
        });
    </script>
</body>
</html>
# Mouse Tracking Image Viewer

A small PHP and JavaScript project that makes a portrait follow your mouse. As you move the cursor, the viewer switches among images showing the character at different angles.

Use it for stream overlays, profile pages, or other small interactive projects. It runs in a PHP-enabled web server and a modern browser.

## Features

- Tracks the cursor and selects an image for its direction.
- Uses a 60 px center deadzone, where the center image is shown.
- Loads numbered images from the `img/` folder. Supported formats are JPG, JPEG, PNG, GIF, and WebP.
- Includes a responsive layout and dark styling.
- Has no external dependencies.

## Requirements

- PHP with a web server, such as XAMPP, MAMP, WAMP, or Laragon. Alternatively, use PHP's built-in server.
- A modern browser (Chrome, Firefox, Edge, or Safari).
- Character images in the `img/` folder. The default setup uses `1.jpg` through `10.jpg`.

## Run with XAMPP

### 1. Install XAMPP

Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/), then open the XAMPP Control Panel.

### 2. Start Apache

In the Control Panel, click **Start** next to Apache. If Apache cannot start, another program may be using port 80. You can configure Apache to use port 8080 instead.

### 3. Copy the project into `htdocs`

Common `htdocs` locations are:

- Windows: `C:\xampp\htdocs\`
- macOS: `/Applications/XAMPP/htdocs/`
- Linux: `/opt/lampp/htdocs/`

Copy the project folder into `htdocs`. Make sure it contains `index.php` and an `img/` subfolder with your images. For example:

```text
htdocs/
└── myproject/
    ├── index.php
    └── img/
        ├── 1.jpg
        ├── 2.jpg
        ├── ...
        └── 10.jpg
```

### 4. Open the viewer

Visit <http://localhost/myproject/> in your browser. Replace `myproject` with your folder name. Move the cursor around the page to change the character's gaze.

If you use port 8080, visit <http://localhost:8080/myproject/> instead.

## Run with PHP's built-in server

Open a terminal in the project folder (the folder containing `index.php`) and run:

```sh
php -S localhost:8000
```

Then open <http://localhost:8000/> in your browser.

## Image setup

Use images of the same character at different gaze angles. The default numbered set is:

| File | Direction | Suggested pose |
| --- | --- | --- |
| `1.jpg` | Center | Looking straight ahead |
| `2.jpg` | Soft down | Eyes slightly down |
| `3.jpg` | Down | Looking down |
| `4.jpg` | Right | Looking right |
| `5.jpg` | Up | Looking up |
| `6.jpg` | Left | Looking left |
| `7.jpg` | Up-left | Looking up and left |
| `8.jpg` | Soft right | Eyes slightly right |
| `9.jpg` | Up-right | Looking up and right |
| `10.jpg` | Soft up | Eyes slightly up |

The viewer uses `1.jpg` as the center image within the 60 px deadzone. The set has no dedicated down-left image, so that cursor sector uses the down and left poses as the cursor moves farther from the center.

### Image tips

- Keep the character, zoom, and lighting consistent across images.
- Keep the face near the center of each image.
- The image frame is 400 × 500 px and uses `object-fit: cover`, so images are cropped to fill it.
- An image resolution of 600 × 800 px or higher is recommended.
- Compress large images to keep page load times reasonable.

## Customization

The examples below refer to the implementation in `index.php`.

### Change the deadzone

Adjust the distance value in the JavaScript condition:

```js
if (distance > 60) {
  // Change 60 to make the center zone larger or smaller.
}
```

### Change the image frame size

Update the `.image-container` dimensions in the CSS:

```css
.image-container {
  width: 400px;
  height: 500px;
}
```

### Use different file extensions

The image loader supports JPG, JPEG, PNG, GIF, and WebP. For example, you can name the images `1.png`, `2.png`, and so on.

### Add more angles

Add more numbered images and update the JavaScript `SECTORS` mapping so the new images can be selected.

## Troubleshooting

| Problem | Fix |
| --- | --- |
| Blank page or PHP code appears as text | Make sure Apache or the PHP built-in server is running, and open the site through `http://localhost/...` instead of opening `index.php` directly. |
| The “Add Images to img folder” placeholder appears | Check that `img/` contains numbered image files and that the path and extensions are correct. |
| Images do not change as you move the cursor | Move outside the center 60 px deadzone and check the browser console for errors. |
| Apache will not start | Another program may be using port 80. Stop that program or configure Apache to use another port. |
| Images look stretched or unexpectedly cropped | Use images with similar aspect ratios. The viewer uses `object-fit: cover`, which crops images to fill the frame. |
| Images return a 404 error | Check the file names and capitalization. On Linux and macOS, `1.JPG` and `1.jpg` are different names. |

## Project structure

```text
your-folder-name/
├── index.php        # PHP, HTML, CSS, and JavaScript for the viewer
└── img/             # Numbered character images
    ├── 1.jpg
    ├── 2.jpg
    ├── ...
    └── 10.jpg
```

## Ideas for extensions

- Make the background transparent for use as a Twitch or Discord overlay.
- Play a sound when the character looks in a particular direction.
- Replace the individual images with a sprite sheet.
- Explore eye tracking with a library such as WebGazer.js.

## License

Free to use, modify, and share. Credit is appreciated but not required.
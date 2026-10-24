# Mouse Tracking Image Viewer

A small PHP + JavaScript project that makes a portrait follow your mouse around the screen. Move the cursor and the image swaps between 10 pre-rendered angles so the character looks like it's looking exactly where your cursor is.

It's meant for stuff like VTuber overlays, stream alerts, profile pages, or just messing around. Nothing fancy to install, just PHP and a browser.

## Features

- Real-time mouse tracking, the image reacts to where your cursor is
- 8-direction look logic with smooth distance-based blending
- Auto-loads images from the `img/` folder (jpg, jpeg, png, gif, webp)
- Responsive, works on mobile too
- No dependencies, just PHP and a browser
- Clean dark UI out of the box

## How it works

You give it 10 images of the same character from different angles. The script checks which direction the mouse is from the center of the screen and swaps to the matching image.

- Far from center means the character looks further in that direction
- Close to center means the character looks almost straight ahead
- Inside the 60px deadzone it always shows the center image, `1.jpg`

## Requirements

- XAMPP (or any PHP server like MAMP, WAMP, Laragon, or `php -S localhost:8000`)
- A modern browser (Chrome, Firefox, Edge, Safari)
- 10 images named `1.jpg` through `10.jpg`

This guide uses XAMPP because it's the easiest for beginners.

## Installation with XAMPP

### Step 1 - Install XAMPP

1. Go to https://www.apachefriends.org/
2. Download the installer for your OS (Windows, macOS, or Linux).
3. Run the installer and keep the default settings.
4. Open the XAMPP Control Panel.

### Step 2 - Start Apache

In the XAMPP Control Panel, click Start next to Apache. You should see the module turn green.

If Apache won't start, port 80 is probably taken by something like Skype or IIS. Change Apache's port in `httpd.conf` to 8080 and use `http://localhost:8080/...` instead.

### Step 3 - Copy the project into htdocs

The `htdocs` folder is where Apache serves files from.

- Windows: `C:\xampp\htdocs\`
- macOS: `/Applications/XAMPP/htdocs/`
- Linux: `/opt/lampp/htdocs/`

1. Open `htdocs`.
2. Create a new folder and name it whatever you want. For the rest of this guide I'll call it `myproject`, but you can use any name.
3. Put `index.php` inside that folder.
4. Create a subfolder called `img` inside it.
5. Drop your 10 images into `img/`, named `1.jpg` through `10.jpg`.

Your folder should look like this (using `myproject` as the example name):
htdocs/
└── myproject/
├── index.php
└── img/
├── 1.jpg
├── 2.jpg
├── 3.jpg
├── 4.jpg
├── 5.jpg
├── 6.jpg
├── 7.jpg
├── 8.jpg
├── 9.jpg
└── 10.jpg

### Step 4 - Open it in your browser

Go to:
http://localhost/myproject/

Replace `myproject` with whatever you actually named your folder. Move your mouse around the page and the character should follow you.

## Image setup - which is the important part

The numbering follows a counter-clockwise rotation around the character's head, starting from the center.

| File | Direction | What the image should show |
|------|-----------|----------------------------|
| `1.jpg` | Center | Looking straight at the viewer |
| `2.jpg` | Left | Looking to the left |
| `3.jpg` | Down | Looking down |
| `4.jpg` | Right | Looking to the right |
| `5.jpg` | Up | Looking up |
| `6.jpg` | Down-Left | Looking down and to the left |
| `7.jpg` | Left (soft) | Eyes only, slightly to the left |
| `8.jpg` | Left-Low | Eyes left, a little downward |
| `9.jpg` | Up-Right | Looking up and to the right |
| `10.jpg` | Up (soft) | Eyes up, head mostly straight |


That's a counter-clockwise sweep: left, down, right, up. Images 6 through 10 are the in-between angles that fill the gaps and add finer motion.
You can download my pic first to copy and then just do the pose that i did.
For now, It's 10 pics but i'll upgrade it sooner for the user to also put in their project protfolio.


### Image tips for the best result

- Use the same character, same zoom, same lighting in every shot.
- Keep the face roughly centered in the frame.
- Use a square-ish or portrait aspect ratio. The frame is 400x500 and images are cropped with `object-fit: cover`.
- Recommended resolution is 600x800 or larger.
- Keep the file size reasonable. Compress with something like Squoosh or TinyPNG.

## Customization

Open `index.php` and tweak these values inside the script block.

### Change the deadzone

The center area where the character looks straight ahead:

if (distance > 60) {   // change 60 to make the center zone bigger or smaller
Change the image frame size
In the CSS:

css
.image-container {
    width: 400px;    /* change me */
    height: 500px;   /* change me */
}
Use different file extensions
The loader already supports jpg, jpeg, png, gif, and webp:

php
$images = glob($imageDir . '[0-9]*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
Just name your files 1.png, 2.png, and so on, and it'll work.

Add more angles
Add images 11.jpg, 12.jpg, and so on, then extend the SECTORS array in the JavaScript.

js
const SECTORS = [
    [IMG_RIGHT, IMG_EXTRA_ANGLE],  // etc.
    ...
];
Troubleshooting
Problem	Fix
Blank page or PHP code shown as text	Apache isn't running, or you opened index.php by double-clicking it. Visit it through http://localhost/....
The "Add Images to img folder" placeholder shows	The img/ folder is empty, or the files aren't named 1.jpg through 10.jpg. Check the path and extensions.
Images don't swap when I move the mouse	Make sure you're moving the mouse outside the center 60px deadzone. Also check the browser console (F12) for errors.
Apache won't start	Another program is using port 80. Close it, or change Apache's port to 8080 in httpd.conf.
Images look stretched or cropped weirdly	Use images with a similar aspect ratio. The CSS uses object-fit: cover, which crops to fill.
404 on the images	File names are case-sensitive on Linux and macOS. 1.JPG is not the same as 1.jpg.
Project structure
text
your-folder-name/
├── index.php        // the whole app (PHP + HTML + JS + CSS)
└── img/             // your 10 angle images
    ├── 1.jpg
    ├── 2.jpg
    ├── ...
    └── 10.jpg
  
###Ideas and extensions
Turn it into a Twitch or Discord overlay by making the background transparent.

Add sound effects when the character looks in a certain direction.

Swap the static 10-image set for a sprite sheet with CSS steps.

Track eye position instead of mouse position with WebGazer.js.

###License
Free to use, modify, and share. Credit is appreciated but not required. Go make something cool.

Made with love and way too much caffeine. If this helped you, drop a star on the repo.

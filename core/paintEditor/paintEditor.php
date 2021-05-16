<head> <link rel="stylesheet" href="paintstyle.css"> </head>
<div class="apppaint">
  <div class="controls">
    <div class="title">Drawing tool</div>
    <div class="type">
      <input type="radio" name="pen-type" id="pen-pencil" checked>
      <label for="pen-pencil">
        <i class="fa fa-pencil"></i>
      </label>
      <input type="radio" name="pen-type" id="pen-brush">
      <label for="pen-brush">
        <i class="fa fa-paint-brush"></i>
      </label>
    </div>
    <div class="size">
      <label for="pen-size">Size</label>
      <input type="range" id="pen-size" min="1" max="50">
    </div>
    <div class="color">
      <label for="pen-color">Color</label>
      <input type="color" id="pen-color" value="#000">
    </div>
    <div class="actions">
	  <></>
      <button id="reset-canvas">Reset</button>
      <button id="save-canvas">Save</button>
    </div>
  </div>
  <div id="canvas-wrapper"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.5.6/p5.min.js"></script>
<script src = "paintscript.js"></script>
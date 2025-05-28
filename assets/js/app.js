

function SearchData(searchinput, items_box) {
  // Get the search input
  var searchInput = document.getElementById("" + searchinput + "").value;

  // Get all content items
  var contentItems = document.getElementsByClassName("" + items_box + "");

  // Loop through all content items
  for (var i = 0; i < contentItems.length; i++) {
    // Get the current item
    var item = contentItems[i];

    // Get the text of the current item
    var itemText = item.textContent.toLowerCase();

    // Check if the search input is found in the item text
    if (itemText.includes(searchInput.toLowerCase())) {
      // If found, show the item
      item.style.display = "block";
    } else {
      // If not found, hide the item
      item.style.display = "none";
    }
  }
}

function ControlForms(FormEelementId) {
  // Get the form element
  formContainerID = document.getElementById(FormEelementId);

  if (formContainerID.style.display == "block") {
    // Hide the form
    formContainerID.style.display = "none";
  } else {
    // Show the form
    formContainerID.style.display = "block";
  }
}

function PreviewImages(inputId, previewId) {
  var input = document.getElementById(inputId);
  var previewContainer = document.getElementById(previewId);
  previewContainer.innerHTML = ""; // Clear previous previews

  if (input.files) {
    var filesArray = Array.from(input.files);

    filesArray.forEach((file, index) => {
      if (!file.type.startsWith("image/")) {
        alert("Only image files are allowed!");
        return;
      }

      var reader = new FileReader();

      reader.onload = function (event) {
        var fileWrapper = document.createElement("div");
        fileWrapper.style.display = "inline-block";
        fileWrapper.style.position = "relative";
        fileWrapper.style.margin = "5px";

        var img = document.createElement("img");
        img.src = event.target.result;
        img.style.maxWidth = "50px";
        img.style.height = "50px";
        img.style.border = "1px solid black";
        img.style.borderRadius = "5px";
        img.style.display = "block";

        var removeBtn = document.createElement("button");
        removeBtn.innerHTML = "<i class='fa fa-times'></i>";
        removeBtn.style.position = "absolute";
        removeBtn.style.top = "-10px";
        removeBtn.style.right = "-5px";
        removeBtn.style.background = "red";
        removeBtn.style.color = "white";
        removeBtn.style.border = "none";
        removeBtn.style.cursor = "pointer";
        removeBtn.style.fontSize = "12px";
        removeBtn.style.borderRadius = "50%";
        removeBtn.style.padding = "5px 9px";

        removeBtn.onclick = function () {
          filesArray.splice(index, 1);
          updateFileInput(input, filesArray);
          fileWrapper.remove();
        };

        fileWrapper.appendChild(img);
        fileWrapper.appendChild(removeBtn);
        previewContainer.appendChild(fileWrapper);
      };

      reader.readAsDataURL(file);
    });
  }
}

function PreviewFiles(inputId, previewId) {
  var input = document.getElementById(inputId);
  var previewContainer = document.getElementById(previewId);
  previewContainer.innerHTML = ""; // Clear previous previews

  if (input.files) {
    var filesArray = Array.from(input.files);

    filesArray.forEach((file, index) => {
      if (file.type !== "application/pdf") {
        alert("Only PDF files are allowed!");
      }

      var reader = new FileReader();

      reader.onload = function (event) {
        var fileWrapper = document.createElement("div");
        fileWrapper.style.display = "inline-block";
        fileWrapper.style.position = "relative";
        fileWrapper.style.margin = "5px";
        fileWrapper.style.textAlign = "center";

        var iframe = document.createElement("iframe");
        iframe.src = event.target.result;
        iframe.style.maxWidth = "80px";
        iframe.style.height = "120px";
        iframe.style.borderStyle = "groove";
        iframe.style.borderColor = "black";
        iframe.style.borderWidth = "1px";
        iframe.style.borderRadius = "1rem";

        var removeBtn = document.createElement("button");
        removeBtn.innerHTML = "<i class='fa fa-times'></i>";
        removeBtn.style.position = "absolute";
        removeBtn.style.top = "-10px";
        removeBtn.style.right = "-5px";
        removeBtn.style.background = "red";
        removeBtn.style.color = "white";
        removeBtn.style.border = "none";
        removeBtn.style.cursor = "pointer";
        removeBtn.style.fontSize = "12px";
        removeBtn.style.borderRadius = "50%";
        removeBtn.style.padding = "5px 9px";

        removeBtn.onclick = function () {
          filesArray.splice(index, 1);
          updateFileInput(input, filesArray);
          fileWrapper.remove();
        };

        fileWrapper.appendChild(iframe);
        fileWrapper.appendChild(removeBtn);
        previewContainer.appendChild(fileWrapper);
      };

      reader.readAsDataURL(file);
    });
  }
}

function updateFileInput(input, filesArray) {
  var dataTransfer = new DataTransfer();
  filesArray.forEach((file) => dataTransfer.items.add(file));
  input.files = dataTransfer.files;
}

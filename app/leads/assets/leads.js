// Select All functionality
document.getElementById("selectAll").addEventListener("change", function (e) {
  document.querySelectorAll(".d-selection").forEach((checkbox) => {
    checkbox.checked = e.target.checked;
  });
  // Show/hide based on if any are checked
  document.getElementById("RemoveButtonOption").style.display = e.target.checked
    ? "block"
    : "none";
  document.getElementById("AssignButtonOption").style.display = e.target.checked
    ? "block"
    : "none";
  document.getElementById("SelectionActivityOptions").style.display = e.target
    .checked
    ? "block"
    : "none";
});

// Individual checkbox functionality
document
  .querySelectorAll('.d-selection[name="SELECTED_LEADS[]"]')
  .forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
      const allChecked = Array.from(
        document.querySelectorAll('.d-selection[name="SELECTED_LEADS[]"]')
      ).every((cb) => cb.checked);
      document.getElementById("selectAll").checked = allChecked;

      // Check if at least one checkbox is checked
      const anyChecked = Array.from(
        document.querySelectorAll('.d-selection[name="SELECTED_LEADS[]"]')
      ).some((cb) => cb.checked);
      document.getElementById("AssignButtonOption").style.display = anyChecked
        ? "block"
        : "none";
      document.getElementById("RemoveButtonOption").style.display = anyChecked
        ? "block"
        : "none";
      document.getElementById("SelectionActivityOptions").style.display =
        anyChecked ? "block" : "none";
    });
  });

function showAssignModal() {
  const selected = getSelectedLeadsData();
  if (selected.length === 0) {
    alert("Please select at least one lead");
    return;
  }
  const content = selected
    .map(
      (lead) =>
        `<div class='selected-leads small'>
        <input type='checkbox' checked hidden name='selected_leads_id[]' value='${lead.id}'>
        <b>Name:</b> ${lead.name}, <b>Phone:</b> ${lead.phone}
        </div>`
    )
    .join("");
  document.getElementById("assignSelectedLeads").innerHTML = content;
  document.getElementById("assignModal").style.display = "block";
}

function showRemoveModal() {
  const selected = getSelectedLeadsData();
  if (selected.length === 0) {
    alert("Please select at least one lead");
    return;
  }
  const content = selected
    .map(
      (lead) =>
        `<div class='selected-leads small'>
        <input type='checkbox' checked hidden name='selected_leads_id[]' value='${lead.id}'>
        <b>Name:</b> ${lead.name}, <b>Phone:</b> ${lead.phone}
        </div>`
    )
    .join("");
  document.getElementById("removeSelectedLeads").innerHTML = content;
  document.getElementById("removeModal").style.display = "block"; // Fixed typo: Display -> display
}

function showMoveModal() {
  const selected = getSelectedLeadsData();
  if (selected.length === 0) {
    alert("Please select at least one lead");
    return;
  }
  const content = selected
    .map(
      (lead) =>
        `<div class='selected-leads small'>
        <input type='checkbox' checked hidden name='selected_leads_id[]' value='${lead.id}'>
        <b>Name:</b> ${lead.name}, <b>Phone:</b> ${lead.phone}
        </div>`
    )
    .join("");
  document.getElementById("moveSelectedLeads").innerHTML = content;
  document.getElementById("moveModal").style.display = "block";
}

function closeModal(modalId) {
  document.getElementById(modalId).style.display = "none";
}

function getSelectedLeadsData() {
  return Array.from(
    document.querySelectorAll('.d-selection[name="SELECTED_LEADS[]"]:checked')
  ).map((cb) => ({
    id: cb.value,
    name: cb.parentElement.nextElementSibling.nextElementSibling.textContent.trim(),
    phone:
      cb.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.textContent.trim(),
  }));
}

function submitAssign() {
  const selected = getSelectedLeadsData();
  const assignUser = document.getElementById("assignUser").value;
  const assignStage = document.getElementById("assignStage").value;

  if (!assignUser || !assignStage) {
    alert("Please select both a user and a stage");
    return;
  }

  console.log(
    "Assigning",
    selected,
    "to user",
    assignUser,
    "and stage",
    assignStage
  );
  alert(
    `Assigning ${selected.length} leads to user ID ${assignUser} and stage ID ${assignStage}`
  );
  document.getElementById("AssignFormForLeads").submit();
}

function submitMove() {
  const selected = getSelectedLeadsData();
  const moveStage = document.getElementById("moveStage").value;
  console.log("Moving", selected, "to stage", moveStage);
  alert(`Moving ${selected.length} leads to stage ID ${moveStage}`);
  closeModal("moveModal");
}

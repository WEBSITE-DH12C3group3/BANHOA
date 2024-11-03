function search() {
  const searchValue = document
    .getElementById("searchBox")
    .value.toLowerCase()
    .trim(); // Trim whitespace
  const rows = document.querySelectorAll("#Table tbody tr"); // Use table ID for better performance
  const noResult = document.getElementById("noResult"); // Get the no results element

  let found = false;

  rows.forEach((row) => {
    const cells = Array.from(row.cells); // Convert HTMLCollection to Array for better compatibility
    const match = cells.some((cell) =>
      cell.textContent.toLowerCase().includes(searchValue)
    ); // Use some() for efficiency

    row.style.display = match ? "" : "none";
    if (match) {
      found = true;
    }
  });

  noResult.style.display = found ? "none" : "block"; // Show/hide no results message
}

// Event listener for the search box (add this to your document.ready)
document.getElementById("searchBox").addEventListener("input", search); // Use "input" event for live search

// Example HTML for the "no results" message
// <div id="noResult" style="display: none;">No results found.</div>

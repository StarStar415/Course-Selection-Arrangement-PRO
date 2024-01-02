// export PDF
function start() {
    document.getElementById("exportButton").addEventListener("click", () => {
      let table = document.getElementById("classTable");
  
      const width = table.offsetWidth;
      const height = table.offsetHeight;
  
      let printWindow = window.open("", "", `width=${width}, height=${height}`);
  
      printWindow.document.write("<html><head><title>Print Table</title>");
      printWindow.document.write("</head><body></body></html>");
      printWindow.document.close();
  
      printWindow.document.body.innerHTML = `
              <style>
              html, body {
                  margin: 0;
                  padding: 10px;
              }
  
              table, th, td {
                  border: 1px solid;
              }
              body {
                  display: flex;
                  justify-content: center;
                  align-items: center;
              }
  
              table {
                  width: 100%;
                  height: auto;
                  border-collapse: collapse;
              }
              </style>
              <table>
                  ${table.innerHTML}
              </table>
          `;
  
      printWindow.focus();
      printWindow.print();
      printWindow.close();
    });
  }
  
  window.addEventListener("load", start, false);
  
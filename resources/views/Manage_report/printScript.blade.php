<script>
function printTable() {
    var content = document.getElementById('printArea').innerHTML;
    // Create a hidden iframe
    var iframe = document.createElement('iframe');
    iframe.style.position = 'absolute';
    iframe.style.width = '0px';
    iframe.style.height = '0px';
    iframe.style.border = '0';
    document.body.appendChild(iframe);

    var doc = iframe.contentWindow.document;
    doc.open();
    doc.write(`
        <html>
        <head>
            <title>Print</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 10px;
                }
                .page-break {
                    page-break-before: always;
                    display: block;
                }
                h3 {
                    color: #007BFF;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 10px;
                }
                th, td {
                    border: 1px solid black;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);
    doc.close();

    // Wait for content to load and then print
    iframe.contentWindow.focus();
    iframe.contentWindow.print();

    // Remove iframe after printing
    setTimeout(() => {
        document.body.removeChild(iframe);
    }, 1000);
}
</script>

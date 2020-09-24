import React from 'react';
import reactDOM from 'react-dom'

import { PDFDownloadLink } from "@react-pdf/renderer";
import PdfDocument from "./InvoiceDocument";

const InvoiceButton = ({ invoice }) => {
    return ( 
        <button className="btn orange btn-block btn-sm">
            <PDFDownloadLink
                document={<PdfDocument facture={invoice} />}
                fileName={ invoice.numero +"-"+ invoice.devis.client.nom + ".pdf" }
                >
                {({ blob, url, loading, error }) => loading ? "Loading..." : "Télécharger" }
            </PDFDownloadLink>
        </button>
     );
}

const rootElement = document.querySelector('#react_invoice_btn')
if( rootElement) {
    const invoice = rootElement.dataset.invoice
    reactDOM.render(<InvoiceButton invoice={ JSON.parse(invoice) }/>, rootElement)
}
 
export default InvoiceButton;


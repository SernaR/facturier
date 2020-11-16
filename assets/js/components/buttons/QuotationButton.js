import React from 'react';
import reactDOM from 'react-dom'

import { PDFDownloadLink } from "@react-pdf/renderer";
import PdfDocument from "../documents/QuotationDocument";

const QuotationButton = ({ quotation }) => {
    return ( 
        <button className="btn orange btn-block btn-sm">
            <PDFDownloadLink
                document={<PdfDocument devis={quotation} />}
                fileName={ quotation.id +"-"+ quotation.client.nom + ".pdf" }
                >
                {({ blob, url, loading, error }) => loading ? "Loading..." : "Télécharger" }
            </PDFDownloadLink>
        </button>
     );
}

const rootElement = document.querySelector('#react_quotation_btn')
if( rootElement) {
    const quotation = rootElement.dataset.quotation
    reactDOM.render(<QuotationButton quotation={ JSON.parse(quotation) }/>, rootElement)
}
 
export default QuotationButton;


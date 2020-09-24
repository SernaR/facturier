import React from 'react';
import reactDOM from 'react-dom'

import { PDFDownloadLink } from "@react-pdf/renderer";
import PdfDocument from "./PdfDocument";

const PdfButton = ({ data }) => {
    return ( 
        <button className="btn orange btn-block btn-sm">
            <PDFDownloadLink
                document={<PdfDocument data={data} />}
                fileName={ data.numero +"-"+ data.devis.client.nom + ".pdf" }
                >
                {({ blob, url, loading, error }) => loading ? "Loading..." : "Télécharger" }
            </PDFDownloadLink>
        </button>
     );
}

const rootElement = document.querySelector('#pdfButton')
if( rootElement) {
    const data = rootElement.dataset.advance
    reactDOM.render(<PdfButton data={ JSON.parse(data) }/>, rootElement)
}
 
export default PdfButton;


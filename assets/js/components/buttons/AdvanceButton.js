import React from 'react';
import reactDOM from 'react-dom'

import { PDFDownloadLink } from "@react-pdf/renderer";
import PdfDocument from "../documents/AdvanceDocument";

const AdvanceButton = ({ advance }) => {
    return ( 
        <button className="btn orange btn-block btn-sm">
            <PDFDownloadLink
                document={<PdfDocument accompte={advance} />}
                fileName={ advance.numero +"-"+ advance.devis.client.nom + ".pdf" }
                >
                {({ blob, url, loading, error }) => loading ? "Loading..." : "Télécharger" }
            </PDFDownloadLink>
        </button>
     );
}

const rootElement = document.querySelector('#react_advance_btn')
if( rootElement) {
    const advance = rootElement.dataset.advance
    reactDOM.render(<AdvanceButton advance={ JSON.parse(advance) }/>, rootElement)
}
 
export default AdvanceButton;


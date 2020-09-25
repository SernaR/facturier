import React from 'react';
import reactDOM from 'react-dom'

import { PDFDownloadLink } from "@react-pdf/renderer";
import PdfDocument from "./DebitDocument";

const DebitButton = ({ debit }) => {
    return ( 
        <button className="btn orange btn-block btn-sm">
            <PDFDownloadLink
                document={<PdfDocument avoir={debit} />}
                fileName={ debit.numero +"-"+ debit.facture.devis.client.nom + ".pdf" }
                >
                {({ blob, url, loading, error }) => loading ? "Loading..." : "Télécharger" }
            </PDFDownloadLink>
        </button>
     );
}

const rootElement = document.querySelector('#react_debit_btn')
if( rootElement) {
    const debit = rootElement.dataset.debit
    reactDOM.render(<DebitButton debit={ JSON.parse(debit) }/>, rootElement)
}
 
export default DebitButton;


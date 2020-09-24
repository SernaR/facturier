import React from "react";
import {
    Page,
    Text,
    View,
    Document,
    StyleSheet,
    Image
} from "@react-pdf/renderer";

import moment from 'moment'

const styles = StyleSheet.create({
    page: {
      fontSize: '8px',
      display: 'flex'
    },
    logo: {
      fontSize: '20px',
    },
    section: {
        border: '1px solid #000',
        //borderBottom: '1px solid #000',
        margin: '10 30',
        padding: 10,
    },
    cockpit : {
      marginTop: 20,
      //border: '1px solid red',
      flexDirection: 'row',
      justifyContent: 'space-between',  
      alignItems: 'baseline',
      //borderBottom: '1px solid #000',
    },
    body1: {
      flexDirection: 'row',
      justifyContent: 'space-around'
    },
    body2: {
      //border: '1px solid red',
      padding: '30 10 0 10'
    },
    title1: {
      borderBottom: '1px solid #000',
      textAlign: 'center',
      fontSize: '12px',
      fontWeight: 700,
      marginBottom: 10,
      padding: 10
    },
    title2: {
      fontSize: '10px',
      fontWeight: 700,
      paddingBottom: 5
    },
    gutterBottom: {
      paddingBottom: '8px',
    }
  });

  export default function PdfDocument() {  //
    return (
      <Document>
        <Page size="A4" style={styles.page}>
            <View style={styles.section}>
              <View style={styles.cockpit}>
                <Text style={styles.logo}>Kip Creativ'</Text>
              </View>
            </View>  
        </Page>
    </Document>
  );
}

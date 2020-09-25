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
  body: {
    paddingTop: 35,
    paddingBottom: 65,
    paddingHorizontal: 35,
    fontSize: 10,
  },
  image: {
    width:150
  },
  header_container:{
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 10,
    paddingBottom: 10
  },
  table_head:{
    flexDirection: 'row',
    fontSize: 9,
    textAlign: 'center',
  	backgroundColor: '#008b8b',
    color: '#fff',
    height:15,
    alignItems: 'center'
  },
  table_body:{
    flexDirection: 'row',
    fontSize: 9,
    textAlign: 'center',
    borderBottom: 1,
    borderLeft: 1
  },
  table_cell:{
    padding : 3, 
    borderRight: 1
  },
  footer:{
    position: 'absolute',
    bottom: 60,
    left: 35,
  },
  pageNumber: {
    position: 'absolute',
    fontSize: 12,
    bottom: 30,
    left: 0,
    right: 0,
    textAlign: 'center',
    color: 'grey',
  }
})

const fetchDetails = (avoir) => {
  let totalAmount = 0
  const rows = avoir.ligneAvoir.map( (ligne, index) => {
    totalAmount += ligne.prestation.montant*ligne.quantite
    return <View style={styles.table_body} wrap={false} key={index}>
      <Text style={[styles.table_cell, {width: 50, fontSize: 8 }]}>{ ligne.prestation.code }</Text>
      <Text style={[styles.table_cell, {width: 100, textAlign: 'left'}]}>{ ligne.prestation.libelle }</Text>
      <Text style={[styles.table_cell, {width: 250, textAlign: 'left'}]}>{ ligne.prestation.description }</Text>
      <Text style={[styles.table_cell, {width: 50}]}>{ ligne.prestation.montant.toFixed(2) } €</Text>
      <Text style={[styles.table_cell, {width: 25}]}>{ ligne.quantite }</Text>
      <Text style={[styles.table_cell, {width: 50}]}>{ (ligne.prestation.montant*ligne.quantite).toFixed(2) } €</Text>
    </View>
  })

  const discount = avoir.facture.devis.discount
  const discountedAmount = totalAmount - (totalAmount*discount/100)
  const advance = avoir.facture.devis.accompte ? avoir.facture.devis.accompte.montant : 0
  const remainingAmount = discountedAmount - advance
  
  return {
    totalAmount: totalAmount.toFixed(2),
    discount,
    discountedAmount: discountedAmount.toFixed(2),
    advance: advance.toFixed(2),
    remainingAmount: remainingAmount.toFixed(2),
    rows
  }
}

export default function InvoiceDocument({ avoir }) {  
  const invoiceDetails = fetchDetails(avoir)

  return (
    <Document>
      <Page style={styles.body} wrap>
        <View fixed>
          <View style={[styles.header_container, {justifyContent: 'space-between', borderBottom: 1}]}>
          <Image
            style={styles.image}
            src="/img/logo-kip-creativ-inline.png"
          />
            <View>
              <Text style={{fontSize: 11, paddingBottom: 3}}>Avoir n° {avoir.numero}</Text>
              <Text>Date: {moment(avoir.date).format('DD/MM/YYYY')}</Text>
            </View>
          </View>

          <View style={[styles.header_container, {justifyContent: 'space-around'}]}>
            <View>
              <Text style={{fontSize: 11}}>Gwenaelle VANHOUTTE</Text>
              <Text>KIP CREATIV'</Text>
              <Text>132 rue de Dunkerque</Text>
              <Text>59200 Tourcoing</Text>
              <Text>Siret 839 250 065 00019</Text>
              <Text>Téléphone: 07 81 21 95 94</Text>
              <Text>Email: kip.creativ@gmail.com</Text>
            </View>
            <View>
              <Text style={{fontSize: 11}}>À: { avoir.facture.devis.client.nom } { avoir.facture.devis.client.prenom }</Text>
              <Text>Entreprise: { avoir.facture.devis.client.societe }</Text>
              <Text>Adresse: { avoir.facture.devis.client.adresse }</Text>
              <Text>TVA intra: { avoir.facture.devis.client.tvaIntracommunautaire }</Text>
              <Text>Téléphone: { avoir.facture.devis.client.telephone }</Text>
              <Text>N° client: C000{ avoir.facture.devis.client.id }</Text>
            </View>
          </View>

          <Text style={{paddingBottom: 5}}>Selon facture n°{ avoir.facture.numero }</Text>

          <View style={styles.table_head}>
            <Text style={{width: 50}}>Référence</Text>
            <Text style={{width: 100}}>Prestation</Text>
            <Text style={{width: 250}}>Description</Text>
            <Text style={{width: 50}}>PU HT</Text>
            <Text style={{width: 25}}>Qté</Text>
            <Text style={{width: 50}}>Montant HT</Text>
          </View>
        </View>  

        { invoiceDetails.rows }
       
        <View style={[styles.header_container, {justifyContent: 'space-between', alignItems: 'flex-start', marginTop: 10}]} wrap={false}>
          <Text style={{paddingVertival: 0 }}></Text>
          <View>
            <View style={[styles.table_body, {borderTop:1}]}>
              <Text style={[styles.table_cell, {width: 50}]}>Total HT</Text>
              <Text style={[styles.table_cell, {width: 75}]}>{ invoiceDetails.totalAmount } €</Text>
            </View>
            <View style={styles.table_body}>
              <Text style={[styles.table_cell, {width: 50}]}>Remise</Text>
              <Text style={[styles.table_cell, {width: 75}]}>{ invoiceDetails.discount } %</Text>
            </View>
            <View style={styles.table_body}>
              <Text style={[styles.table_cell, {width: 50}]}>Total TTC</Text>
              <Text style={[styles.table_cell, {width: 75}]}>{invoiceDetails.discountedAmount} €</Text>
            </View>
            <View style={styles.table_body}>
              <Text style={[styles.table_cell, {width: 50}]}>Acompte</Text>
              <Text style={[styles.table_cell, {width: 75}]}>{invoiceDetails.advance} €</Text>
            </View>
            <View style={styles.table_body}>
              <Text style={[styles.table_cell, {width: 50}]}>Avoir</Text>
              <Text style={[styles.table_cell, {width: 75, fontSize: 10}]}>-{invoiceDetails.remainingAmount} €</Text>
            </View>
            <Text style={{ width: 125, marginTop: 3, fontSize: 8}}>TVA non applicable, article 293-B du CGI</Text>
          </View>
        </View>
        <View style={styles.footer} wrap={false}>
          <Text style={{ marginTop: 10 }}>Règlement: chèque ou virement</Text>
          <View style={{ fontSize: 8 }}> 
            <Text style={{ marginTop: 5 }}>Chèque libellé à l'ordre de: Vanhoutte Gwenaelle</Text>
            <Text>Iban: Vanhoutte Gwenaelle | FR76 1254 8029 9846 4238 6150 810 | BIC: AXABFRPP </Text>
            <Text style={{ marginTop: 10 }}>- Conditions de réglement: acompte de 30% à la signature du devis, solde dans un délai maximum de 30 jours suivant la date de livraison</Text>
            <Text>- Conditions d'escompte: aucun escompte ne sera consenti pour réglement anticipé</Text>
            <Text>- Toute somme non payée à sa date d'exigibilité produira de plein droits des intérêts de retard équivalent à 10% des sommes dues ainsi qu'une indemnité forfaitaire de 40€ pour frais de recouvrement</Text> 
          </View>
          <Text style={{ marginTop: 10 }}>Merci pour votre confiance</Text>
        </View>
      
        <Text style={styles.pageNumber} render={({ pageNumber, totalPages }) => (
          `${pageNumber} / ${totalPages}`
        )} fixed />
      </Page>
      <Page style={styles.body} wrap>
        <Text>visuelle du site (page accueil) + 3 allers-retour éventuels - Correction des autres pages en live si besoin - Personnalisa-tion du site aux couleurs de l'entreprise - Restructuration du site si besoin (pages et contenus) - Mentions légales / RGPD - Installation plugins de sécurité/sauvegarde - Référencement de base pour les moteurs de recherche - OFFERT: 1h de prise en main avec le client + notice d’utilisation Non compris: - Les pages ou modifications supplémentaires - Le nouveau contenu du site (textes, images, mots clés) - La ma</Text>
        <Text style={styles.pageNumber} render={({ pageNumber, totalPages }) => (
          `${pageNumber} / ${totalPages}`
        )} fixed />
      </Page>
    </Document>
  )
}

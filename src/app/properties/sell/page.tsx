import React from 'react';

export default function SellPropertiesPage() {
  return (
    <div className="container mx-auto px-4 py-12">
      <h1 className="text-4xl font-bold text-center mb-10">Vender tu Propiedad con ThellSol</h1>
      <p className="text-center mb-8">Proceso seguro, rápido y sin complicaciones.</p>
      <div className="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-8">
        <p className="mb-2">En ThellSol, te acompañamos en todo el proceso de venta de tu propiedad en España, asegurando una experiencia segura, ágil y sin complicaciones.</p>
        <p className="mb-2">Además, contamos con el respaldo legal del prestigioso despacho de abogados Martínez-Echevarría, lo que nos permite ofrecerte una gestión completa y profesional con total garantía jurídica.</p>
      </div>
      <div className="max-w-2xl mx-auto space-y-4">
        <div className="bg-gray-50 p-4 rounded shadow">
          <strong>1. Valoración y puesta en venta</strong>
          <p>Realizamos una valoración profesional de tu vivienda y la publicamos en los canales adecuados para encontrar el mejor comprador.</p>
        </div>
        <div className="bg-gray-50 p-4 rounded shadow">
          <strong>2. Reserva del comprador</strong>
          <p>El comprador interesado realiza un depósito de reserva y se retira la propiedad del mercado.</p>
        </div>
        <div className="bg-gray-50 p-4 rounded shadow">
          <strong>3. Preparación legal de la venta</strong>
          <p>Revisión de escrituras, certificados y situación legal de la propiedad.</p>
        </div>
        <div className="bg-gray-50 p-4 rounded shadow">
          <strong>4. Firma del contrato privado</strong>
          <p>Se redacta y firma el contrato privado de compraventa.</p>
        </div>
        <div className="bg-gray-50 p-4 rounded shadow">
          <strong>5. Firma de la escritura pública de compraventa</strong>
          <p>En notaría, con entrega de llaves y pago final.</p>
        </div>
        <div className="bg-gray-50 p-4 rounded shadow">
          <strong>6. Liquidación de impuestos y gestiones finales</strong>
          <p>Nos encargamos de todos los trámites fiscales y registrales.</p>
        </div>
        <div className="bg-blue-50 p-4 rounded shadow border border-blue-200">
          <strong>Vende tu casa con tranquilidad, respaldo legal y acompañamiento profesional</strong>
          <p>Nosotros gestionamos todo. Tú solo te ocupas de recibir el dinero de tu venta.</p>
        </div>
      </div>
    </div>
  );
} 
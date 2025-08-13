import React from 'react';

export default function InformacionLegalPage() {
  return (
    <div className="container mx-auto px-4 py-12">
      <h1 className="text-4xl font-bold text-center mb-10">Información Legal y Guías</h1>
      <div className="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg mb-12">
        <h2 className="text-2xl font-semibold text-blue-900 mb-6 text-center">Documentos Legales y Guías de Compra</h2>
        <div className="flex justify-center mb-8">
          <img 
            src="/images/martinez-echevarria-logo.jpg"
            alt="Martínez Echevarría Abogados Logo"
            className="h-24 object-contain"
          />
        </div>
        <ul className="space-y-3">
          <li><a href="/docs/ME_FolletoInmo_Español.pdf" target="_blank" className="text-blue-700 hover:underline font-medium">Guía de Compra (Español)</a></li>
          <li><a href="/docs/ME_FolletoInmo_Ingles.pdf" target="_blank" className="text-blue-700 hover:underline font-medium">Buying Guide (English)</a></li>
          <li><a href="/docs/MARTINEZ ECHEVARRIA - GUIA DE COMPRA - FRANÇAIS.pdf" target="_blank" className="text-blue-700 hover:underline font-medium">Guide d'Achat (Français)</a></li>
          <li><a href="/docs/ME_FolletoInmo_Ruso.pdf" target="_blank" className="text-blue-700 hover:underline font-medium">Руководство по покупке (Русский)</a></li>
          <li><a href="/docs/ME_FolletoInmo_Polaco.pdf" target="_blank" className="text-blue-700 hover:underline font-medium">Przewodnik Zakupu (Polski)</a></li>
          <li><a href="/docs/ME köp guide 2024.pdf" target="_blank" className="text-blue-700 hover:underline font-medium">Köpguide (Svenska)</a></li>
        </ul>
      </div>
      <div className="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 className="text-2xl font-semibold text-blue-900 mb-6 text-center">Videos Informativos</h2>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div className="aspect-w-16 aspect-h-9">
            <iframe 
              src="https://www.youtube.com/embed/VIDEO_ID_1"
              title="Video Explicativo 1"
              frameBorder="0" 
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
              allowFullScreen
              className="w-full h-full rounded-lg shadow-md"
            ></iframe>
          </div>
          <div className="aspect-w-16 aspect-h-9">
            <iframe 
              src="https://www.youtube.com/embed/VIDEO_ID_2"
              title="Video Explicativo 2"
              frameBorder="0" 
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
              allowFullScreen
              className="w-full h-full rounded-lg shadow-md"
            ></iframe>
          </div>
        </div>
      </div>
    </div>
  );
} 
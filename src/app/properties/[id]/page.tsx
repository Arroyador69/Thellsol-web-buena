'use client';

import React, { useState, useEffect } from 'react';
import Image from 'next/image';
import Link from 'next/link';

interface Property {
  id: string;
  title: string;
  description: string;
  price: number;
  location: string;
  type: string;
  bedrooms?: number;
  bathrooms?: number;
  area?: number;
  features?: {
    parking?: boolean;
    pool?: boolean;
    garden?: boolean;
    terrace?: boolean;
    airConditioning?: boolean;
    heating?: boolean;
    elevator?: boolean;
    furnished?: boolean;
  };
  images: string[];
  status: string;
  createdAt: string;
  updatedAt: string;
}

export default function PropertyDetail({ params }: { params: { id: string } }) {
  const [property, setProperty] = useState<Property | null>(null);
  const [loading, setLoading] = useState(true);
  const [currentImageIndex, setCurrentImageIndex] = useState(0);

  useEffect(() => {
    fetch(`/api/properties/${params.id}`)
      .then(res => res.json())
      .then(data => {
        setProperty(data);
        setLoading(false);
      })
      .catch(error => {
        console.error('Error loading property:', error);
        setLoading(false);
      });
  }, [params.id]);

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-blue-900 mx-auto"></div>
          <p className="mt-4 text-gray-600">Cargando propiedad...</p>
        </div>
      </div>
    );
  }

  if (!property) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-2xl font-bold text-gray-900 mb-4">Propiedad no encontrada</h1>
          <p className="text-gray-600 mb-6">La propiedad que buscas no existe o ha sido eliminada.</p>
          <Link href="/properties/buy" className="bg-blue-900 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition">
            Ver todas las propiedades
          </Link>
        </div>
      </div>
    );
  }

  const nextImage = () => {
    setCurrentImageIndex((prev) => 
      prev === property.images.length - 1 ? 0 : prev + 1
    );
  };

  const prevImage = () => {
    setCurrentImageIndex((prev) => 
      prev === 0 ? property.images.length - 1 : prev - 1
    );
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-blue-900 text-white py-16">
        <div className="container mx-auto px-4">
          <nav className="mb-4">
            <Link href="/properties/buy" className="text-blue-200 hover:text-white transition">
              ← Volver a propiedades
            </Link>
          </nav>
          <h1 className="text-4xl font-bold mb-2">{property.title}</h1>
          <p className="text-xl">{property.location}</p>
        </div>
      </div>

      <div className="container mx-auto px-4 py-8">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Galería de imágenes */}
          <div className="lg:col-span-2">
            <div className="bg-white rounded-lg shadow-lg overflow-hidden">
              <div className="relative h-96">
                {property.images.length > 0 ? (
                  <>
                    <Image
                      src={property.images[currentImageIndex]}
                      alt={property.title}
                      fill
                      className="object-cover"
                    />
                    {property.images.length > 1 && (
                      <>
                        <button
                          onClick={prevImage}
                          className="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 transition"
                        >
                          ←
                        </button>
                        <button
                          onClick={nextImage}
                          className="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70 transition"
                        >
                          →
                        </button>
                        <div className="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/50 text-white px-3 py-1 rounded-full text-sm">
                          {currentImageIndex + 1} / {property.images.length}
                        </div>
                      </>
                    )}
                  </>
                ) : (
                  <div className="w-full h-full bg-gray-200 flex items-center justify-center">
                    <p className="text-gray-500">Sin imágenes disponibles</p>
                  </div>
                )}
              </div>
              
              {/* Miniaturas */}
              {property.images.length > 1 && (
                <div className="p-4 border-t">
                  <div className="flex gap-2 overflow-x-auto">
                    {property.images.map((image, index) => (
                      <button
                        key={index}
                        onClick={() => setCurrentImageIndex(index)}
                        className={`flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 ${
                          currentImageIndex === index ? 'border-blue-500' : 'border-gray-200'
                        }`}
                      >
                        <Image
                          src={image}
                          alt={`${property.title} - Imagen ${index + 1}`}
                          width={80}
                          height={80}
                          className="object-cover w-full h-full"
                        />
                      </button>
                    ))}
                  </div>
                </div>
              )}
            </div>
          </div>

          {/* Información de la propiedad */}
          <div className="lg:col-span-1">
            <div className="bg-white rounded-lg shadow-lg p-6 sticky top-8">
              <div className="text-center mb-6">
                <p className="text-3xl font-bold text-blue-900 mb-2">
                  {property.price.toLocaleString('es-ES')} €
                </p>
                <p className="text-gray-600">{property.type}</p>
              </div>

              {/* Características principales */}
              <div className="grid grid-cols-2 gap-4 mb-6">
                <div className="text-center">
                  <p className="text-2xl font-bold text-blue-900">{property.bedrooms || 0}</p>
                  <p className="text-gray-600 text-sm">Habitaciones</p>
                </div>
                <div className="text-center">
                  <p className="text-2xl font-bold text-blue-900">{property.bathrooms || 0}</p>
                  <p className="text-gray-600 text-sm">Baños</p>
                </div>
                <div className="text-center">
                  <p className="text-2xl font-bold text-blue-900">{property.area || 0}m²</p>
                  <p className="text-gray-600 text-sm">Superficie</p>
                </div>
                <div className="text-center">
                  <p className="text-2xl font-bold text-blue-900">{property.location}</p>
                  <p className="text-gray-600 text-sm">Ubicación</p>
                </div>
              </div>

              {/* Características */}
              {property.features && Object.keys(property.features).length > 0 && (
                <div className="mb-6">
                  <h3 className="text-lg font-semibold mb-3">Características</h3>
                  <div className="grid grid-cols-2 gap-2">
                    {property.features.parking && (
                      <div className="flex items-center text-sm">
                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Parking
                      </div>
                    )}
                    {property.features.pool && (
                      <div className="flex items-center text-sm">
                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Piscina
                      </div>
                    )}
                    {property.features.garden && (
                      <div className="flex items-center text-sm">
                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Jardín
                      </div>
                    )}
                    {property.features.terrace && (
                      <div className="flex items-center text-sm">
                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Terraza
                      </div>
                    )}
                    {property.features.airConditioning && (
                      <div className="flex items-center text-sm">
                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Aire Acondicionado
                      </div>
                    )}
                    {property.features.heating && (
                      <div className="flex items-center text-sm">
                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Calefacción
                      </div>
                    )}
                    {property.features.elevator && (
                      <div className="flex items-center text-sm">
                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Ascensor
                      </div>
                    )}
                    {property.features.furnished && (
                      <div className="flex items-center text-sm">
                        <span className="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Amueblado
                      </div>
                    )}
                  </div>
                </div>
              )}

              {/* Botones de acción */}
              <div className="space-y-3">
                <button className="w-full bg-blue-900 text-white py-3 rounded-lg hover:bg-blue-800 transition">
                  Contactar sobre esta propiedad
                </button>
                <button className="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition">
                  Solicitar visita
                </button>
                <button className="w-full border border-blue-900 text-blue-900 py-3 rounded-lg hover:bg-blue-50 transition">
                  Agregar a favoritos
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Descripción */}
        <div className="mt-8">
          <div className="bg-white rounded-lg shadow-lg p-6">
            <h2 className="text-2xl font-bold text-gray-900 mb-4">Descripción</h2>
            <p className="text-gray-700 leading-relaxed">{property.description}</p>
          </div>
        </div>

        {/* Propiedades similares */}
        <div className="mt-8">
          <div className="bg-white rounded-lg shadow-lg p-6">
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Propiedades similares</h2>
            <div className="text-center text-gray-600">
              <p>Funcionalidad en desarrollo</p>
              <Link href="/properties/buy" className="text-blue-900 hover:underline">
                Ver todas las propiedades
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

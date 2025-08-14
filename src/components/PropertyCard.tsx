import React from 'react';
import Image from 'next/image';
import Link from 'next/link';

interface PropertyCardProps {
  property: {
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
  };
}

export default function PropertyCard({ property }: PropertyCardProps) {
  const formatPrice = (price: number) => {
    return new Intl.NumberFormat('es-ES', {
      style: 'currency',
      currency: 'EUR',
      minimumFractionDigits: 0,
      maximumFractionDigits: 0,
    }).format(price);
  };

  const getTypeLabel = (type: string) => {
    const types: { [key: string]: string } = {
      apartment: 'Apartamento',
      villa: 'Villa',
      house: 'Casa',
      penthouse: 'Ático',
      land: 'Terreno',
      commercial: 'Local Comercial',
      office: 'Oficina'
    };
    return types[type] || type;
  };

  const getStatusLabel = (status: string) => {
    const statuses: { [key: string]: string } = {
      'for-sale': 'En Venta',
      'for-rent': 'En Alquiler',
      'sold': 'Vendida',
      'rented': 'Alquilada'
    };
    return statuses[status] || status;
  };

  const getStatusColor = (status: string) => {
    const colors: { [key: string]: string } = {
      'for-sale': 'bg-green-100 text-green-800',
      'for-rent': 'bg-blue-100 text-blue-800',
      'sold': 'bg-gray-100 text-gray-800',
      'rented': 'bg-purple-100 text-purple-800'
    };
    return colors[status] || 'bg-gray-100 text-gray-800';
  };

  return (
    <div className="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
      {/* Imagen */}
      <div className="relative h-48">
        <Image
          src={property.images[0] || '/images/property-placeholder.jpg'}
          alt={property.title}
          fill
          className="object-cover"
        />
        <div className="absolute top-2 right-2">
          <span className={`px-2 py-1 text-xs font-medium rounded-full ${getStatusColor(property.status)}`}>
            {getStatusLabel(property.status)}
          </span>
        </div>
        <div className="absolute top-2 left-2">
          <span className="px-2 py-1 text-xs font-medium bg-blue-600 text-white rounded-full">
            {getTypeLabel(property.type)}
          </span>
        </div>
      </div>

      {/* Contenido */}
      <div className="p-6">
        <h3 className="text-xl font-semibold text-gray-900 mb-2 line-clamp-1">
          {property.title}
        </h3>
        
        <p className="text-gray-600 mb-2 flex items-center">
          <svg className="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          {property.location}
        </p>

        {/* Características */}
        <div className="flex items-center space-x-4 mb-4 text-sm text-gray-600">
          {property.bedrooms && (
            <span className="flex items-center">
              <svg className="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z" />
              </svg>
              {property.bedrooms} hab
            </span>
          )}
          {property.bathrooms && (
            <span className="flex items-center">
              <svg className="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
              </svg>
              {property.bathrooms} baños
            </span>
          )}
          {property.area && (
            <span className="flex items-center">
              <svg className="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
              </svg>
              {property.area}m²
            </span>
          )}
        </div>

        {/* Características especiales */}
        {property.features && (
          <div className="flex flex-wrap gap-2 mb-4">
            {property.features.parking && (
              <span className="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Parking</span>
            )}
            {property.features.pool && (
              <span className="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">Piscina</span>
            )}
            {property.features.garden && (
              <span className="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">Jardín</span>
            )}
            {property.features.terrace && (
              <span className="px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded">Terraza</span>
            )}
          </div>
        )}

        {/* Precio */}
        <div className="flex items-center justify-between mb-4">
          <span className="text-2xl font-bold text-blue-900">
            {formatPrice(property.price)}
          </span>
        </div>

        {/* Botón */}
        <Link
          href={`/properties/${property.id}`}
          className="block w-full text-center bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200"
        >
          Ver Detalles
        </Link>
      </div>
    </div>
  );
} 
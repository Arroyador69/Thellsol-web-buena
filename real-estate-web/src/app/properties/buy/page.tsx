'use client';

import React, { useState, useEffect } from 'react';
import PropertyCard from '@/components/PropertyCard';

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

export default function BuyProperties() {
  const [properties, setProperties] = useState<Property[]>([]);
  const [loading, setLoading] = useState(true);
  const [filteredProperties, setFilteredProperties] = useState<Property[]>([]);

  useEffect(() => {
    // Cargar propiedades desde la API
    fetch('/api/properties')
      .then(res => res.json())
      .then(data => {
        setProperties(data);
        setFilteredProperties(data);
        setLoading(false);
      })
      .catch(error => {
        console.error('Error loading properties:', error);
        setLoading(false);
      });
  }, []);

  const filterProperties = () => {
    const location = (document.getElementById('location-filter') as HTMLSelectElement)?.value || '';
    const type = (document.getElementById('type-filter') as HTMLSelectElement)?.value || '';
    const minPrice = (document.getElementById('min-price-filter') as HTMLInputElement)?.value || '';
    const maxPrice = (document.getElementById('max-price-filter') as HTMLInputElement)?.value || '';
    const bedrooms = (document.getElementById('bedrooms-filter') as HTMLSelectElement)?.value || '';
    const bathrooms = (document.getElementById('bathrooms-filter') as HTMLSelectElement)?.value || '';

    const filtered = properties.filter(property => {
      if (location && property.location !== location) return false;
      if (type && property.type !== type) return false;
      if (minPrice && property.price < parseInt(minPrice)) return false;
      if (maxPrice && property.price > parseInt(maxPrice)) return false;
      if (bedrooms && property.bedrooms && property.bedrooms < parseInt(bedrooms)) return false;
      if (bathrooms && property.bathrooms && property.bathrooms < parseInt(bathrooms)) return false;
      return true;
    });

    setFilteredProperties(filtered);
  };

  useEffect(() => {
    // Agregar event listeners a los filtros
    const filters = ['location-filter', 'type-filter', 'min-price-filter', 'max-price-filter', 'bedrooms-filter', 'bathrooms-filter'];
    
    const addListeners = () => {
      filters.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
          element.addEventListener('change', filterProperties);
          element.addEventListener('input', filterProperties);
        }
      });
    };

    // Esperar a que el DOM esté listo
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', addListeners);
    } else {
      addListeners();
    }

    return () => {
      filters.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
          element.removeEventListener('change', filterProperties);
          element.removeEventListener('input', filterProperties);
        }
      });
    };
  }, [properties]);

  const clearFilters = () => {
    const filters = ['location-filter', 'type-filter', 'min-price-filter', 'max-price-filter', 'bedrooms-filter', 'bathrooms-filter'];
    filters.forEach(id => {
      const element = document.getElementById(id) as HTMLInputElement | HTMLSelectElement;
      if (element) element.value = '';
    });
    setFilteredProperties(properties);
  };

  if (loading) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-blue-900 mx-auto"></div>
          <p className="mt-4 text-gray-600">Cargando propiedades...</p>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-blue-900 text-white py-16">
        <div className="container mx-auto px-4 text-center">
          <h1 className="text-4xl font-bold mb-4">Propiedades en Venta</h1>
          <p className="text-xl">Encuentra tu hogar ideal en la Costa del Sol</p>
        </div>
      </div>

      <div className="container mx-auto px-4 py-8">
        <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
          {/* Filtros */}
          <div className="lg:col-span-1">
            <div className="bg-white rounded-lg shadow-lg p-6 sticky top-8">
              <h2 className="text-xl font-semibold mb-6">Filtros de Búsqueda</h2>
              
              <div className="space-y-4">
                {/* Información sobre filtros */}
                <div className="text-sm text-gray-600">
                  <p>Los filtros se aplicarán automáticamente cuando selecciones las opciones.</p>
                </div>

                {/* Ubicaciones únicas */}
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Ubicación
                  </label>
                  <select
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    id="location-filter"
                  >
                    <option value="">Todas las ubicaciones</option>
                    {Array.from(new Set(properties.map(p => p.location))).map(location => (
                      <option key={location} value={location}>{location}</option>
                    ))}
                  </select>
                </div>

                {/* Tipos de propiedad únicos */}
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Tipo de Propiedad
                  </label>
                  <select
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    id="type-filter"
                  >
                    <option value="">Todos los tipos</option>
                    {Array.from(new Set(properties.map(p => p.type))).map(type => (
                      <option key={type} value={type}>{type}</option>
                    ))}
                  </select>
                </div>

                {/* Precio */}
                <div className="grid grid-cols-2 gap-2">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Precio mínimo
                    </label>
                    <input
                      type="number"
                      placeholder="€"
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      id="min-price-filter"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Precio máximo
                    </label>
                    <input
                      type="number"
                      placeholder="€"
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      id="max-price-filter"
                    />
                  </div>
                </div>

                {/* Habitaciones y baños */}
                <div className="grid grid-cols-2 gap-2">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Habitaciones
                    </label>
                    <select
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      id="bedrooms-filter"
                    >
                      <option value="">Cualquiera</option>
                      <option value="1">1+</option>
                      <option value="2">2+</option>
                      <option value="3">3+</option>
                      <option value="4">4+</option>
                    </select>
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Baños
                    </label>
                    <select
                      className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                      id="bathrooms-filter"
                    >
                      <option value="">Cualquiera</option>
                      <option value="1">1+</option>
                      <option value="2">2+</option>
                      <option value="3">3+</option>
                    </select>
                  </div>
                </div>

                {/* Botón para limpiar filtros */}
                <button
                  onClick={clearFilters}
                  className="w-full px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition"
                >
                  Limpiar Filtros
                </button>
              </div>
            </div>
          </div>

          {/* Lista de propiedades */}
          <div className="lg:col-span-3">
            <div className="flex justify-between items-center mb-6">
              <h2 className="text-2xl font-semibold text-gray-900">
                Propiedades encontradas ({filteredProperties.length})
              </h2>
            </div>

            {filteredProperties.length === 0 ? (
              <div className="bg-white rounded-lg shadow-lg p-8 text-center">
                <p className="text-gray-500 text-lg">No se encontraron propiedades disponibles.</p>
                <p className="text-gray-400 text-sm mt-2">Contacta con nosotros para más información.</p>
              </div>
            ) : (
              <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                {filteredProperties.map(property => (
                  <PropertyCard key={property.id} property={property} />
                ))}
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
} 
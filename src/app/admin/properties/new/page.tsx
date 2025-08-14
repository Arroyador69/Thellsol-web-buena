'use client';

import React, { useState } from 'react';
import { useRouter } from 'next/navigation';

export default function NewProperty() {
  const router = useRouter();
  const [formData, setFormData] = useState({
    title: '',
    description: '',
    price: '',
    location: '',
    type: 'apartment',
    bedrooms: '',
    bathrooms: '',
    area: '',
    features: {
      parking: false,
      pool: false,
      garden: false,
      terrace: false,
      airConditioning: false,
      heating: false,
      elevator: false,
      furnished: false
    },
    images: [] as string[],
    status: 'for-sale'
  });

  const propertyTypes = [
    { value: 'apartment', label: 'Apartamento' },
    { value: 'villa', label: 'Villa' },
    { value: 'house', label: 'Casa' },
    { value: 'penthouse', label: 'Ático' },
    { value: 'land', label: 'Terreno' },
    { value: 'commercial', label: 'Local Comercial' },
    { value: 'office', label: 'Oficina' }
  ];

  const locations = [
    'Fuengirola',
    'Mijas',
    'Marbella',
    'Benalmádena',
    'Torremolinos',
    'Málaga Centro',
    'Nerja',
    'Estepona',
    'San Pedro de Alcántara',
    'Puerto Banús'
  ];

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleFeatureChange = (feature: string) => {
    setFormData(prev => ({
      ...prev,
      features: {
        ...prev.features,
        [feature]: !prev.features[feature as keyof typeof prev.features]
      }
    }));
  };

  const handleImageUpload = (e: React.ChangeEvent<HTMLInputElement>) => {
    const files = e.target.files;
    if (files) {
      const imageUrls = Array.from(files).map(file => URL.createObjectURL(file));
      setFormData(prev => ({
        ...prev,
        images: [...prev.images, ...imageUrls]
      }));
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    try {
      // Preparar los datos para enviar
      const propertyData = {
        ...formData,
        price: parseFloat(formData.price),
        bedrooms: formData.bedrooms ? parseInt(formData.bedrooms) : null,
        bathrooms: formData.bathrooms ? parseInt(formData.bathrooms) : null,
        area: formData.area ? parseInt(formData.area) : null,
      };

      const response = await fetch('/api/properties', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(propertyData),
      });

      if (!response.ok) {
        throw new Error('Error al guardar la propiedad');
      }

      const result = await response.json();
      alert('Propiedad guardada exitosamente');
      router.push('/admin');
    } catch (error) {
      console.error('Error al guardar la propiedad:', error);
      alert('Error al guardar la propiedad');
    }
  };

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-white rounded-lg shadow-lg">
          <div className="px-6 py-4 border-b border-gray-200">
            <h1 className="text-2xl font-bold text-gray-900">Añadir Nueva Propiedad</h1>
          </div>

          <form onSubmit={handleSubmit} className="p-6 space-y-6">
            {/* Información Básica */}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Título de la Propiedad *
                </label>
                <input
                  type="text"
                  name="title"
                  value={formData.title}
                  onChange={handleInputChange}
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Precio (€) *
                </label>
                <input
                  type="number"
                  name="price"
                  value={formData.price}
                  onChange={handleInputChange}
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Ubicación *
                </label>
                <select
                  name="location"
                  value={formData.location}
                  onChange={handleInputChange}
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
                  <option value="">Seleccionar ubicación</option>
                  {locations.map(location => (
                    <option key={location} value={location}>{location}</option>
                  ))}
                </select>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Tipo de Propiedad *
                </label>
                <select
                  name="type"
                  value={formData.type}
                  onChange={handleInputChange}
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  required
                >
                  {propertyTypes.map(type => (
                    <option key={type.value} value={type.value}>{type.label}</option>
                  ))}
                </select>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Habitaciones
                </label>
                <input
                  type="number"
                  name="bedrooms"
                  value={formData.bedrooms}
                  onChange={handleInputChange}
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Baños
                </label>
                <input
                  type="number"
                  name="bathrooms"
                  value={formData.bathrooms}
                  onChange={handleInputChange}
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Superficie (m²)
                </label>
                <input
                  type="number"
                  name="area"
                  value={formData.area}
                  onChange={handleInputChange}
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Estado
                </label>
                <select
                  name="status"
                  value={formData.status}
                  onChange={handleInputChange}
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="for-sale">En Venta</option>
                  <option value="for-rent">En Alquiler</option>
                  <option value="sold">Vendida</option>
                  <option value="rented">Alquilada</option>
                </select>
              </div>
            </div>

            {/* Descripción */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Descripción *
              </label>
              <textarea
                name="description"
                value={formData.description}
                onChange={handleInputChange}
                rows={4}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
              />
            </div>

            {/* Características */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-4">
                Características de la Propiedad
              </label>
              <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                {Object.entries(formData.features).map(([feature, checked]) => (
                  <label key={feature} className="flex items-center">
                    <input
                      type="checkbox"
                      checked={checked}
                      onChange={() => handleFeatureChange(feature)}
                      className="mr-2"
                    />
                    <span className="text-sm text-gray-700">
                      {feature === 'parking' && 'Parking'}
                      {feature === 'pool' && 'Piscina'}
                      {feature === 'garden' && 'Jardín'}
                      {feature === 'terrace' && 'Terraza'}
                      {feature === 'airConditioning' && 'Aire Acondicionado'}
                      {feature === 'heating' && 'Calefacción'}
                      {feature === 'elevator' && 'Ascensor'}
                      {feature === 'furnished' && 'Amueblado'}
                    </span>
                  </label>
                ))}
              </div>
            </div>

            {/* Imágenes */}
            <div>
              <label className="block text-sm font-medium text-gray-700 mb-2">
                Imágenes de la Propiedad
              </label>
              <input
                type="file"
                multiple
                accept="image/*"
                onChange={handleImageUpload}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              />
              {formData.images.length > 0 && (
                <div className="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                  {formData.images.map((image, index) => (
                    <img
                      key={index}
                      src={image}
                      alt={`Imagen ${index + 1}`}
                      className="w-full h-32 object-cover rounded-md"
                    />
                  ))}
                </div>
              )}
            </div>

            {/* Botones */}
            <div className="flex justify-end space-x-4 pt-6 border-t border-gray-200">
              <button
                type="button"
                onClick={() => router.push('/admin')}
                className="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition"
              >
                Cancelar
              </button>
              <button
                type="submit"
                className="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
              >
                Guardar Propiedad
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
} 
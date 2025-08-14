import React from 'react';
import Image from 'next/image';

export default function ContactPage() {
  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header con imagen */}
      <div className="relative h-64">
        <Image
          src="/images/fuengirola contacto.jpeg"
          alt="Fuengirola"
          fill
          className="object-cover"
        />
        <div className="absolute inset-0 bg-black bg-opacity-50" />
        <div className="absolute inset-0 flex items-center justify-center">
          <div className="text-center text-white">
            <h1 className="text-4xl font-bold mb-4">Contacto</h1>
            <p className="text-xl">Estamos aquí para ayudarte</p>
          </div>
        </div>
      </div>

      <div className="container mx-auto px-4 py-16">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
          {/* Información de contacto */}
          <div>
            <h2 className="text-3xl font-bold text-gray-900 mb-8">Ponte en Contacto</h2>
            
            <div className="space-y-8">
              {/* Información de André */}
              <div className="flex items-start space-x-4">
                <div className="flex-shrink-0">
                  <Image
                    src="/images/andre-profile.jpg"
                    alt="André Richard Tell"
                    width={80}
                    height={80}
                    className="rounded-full"
                  />
                </div>
                <div>
                  <h3 className="text-xl font-semibold text-gray-900">André Richard Tell</h3>
                  <p className="text-gray-600">Agente Inmobiliario</p>
                  <p className="text-gray-600">ThellSol Real Estate</p>
                </div>
              </div>

              {/* Detalles de contacto */}
              <div className="space-y-4">
                <div className="flex items-center space-x-3">
                  <div className="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                  </div>
                  <div>
                    <p className="text-sm font-medium text-gray-900">Teléfono</p>
                    <p className="text-gray-600">+34 XXX XXX XXX</p>
                  </div>
                </div>

                <div className="flex items-center space-x-3">
                  <div className="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                  </div>
                  <div>
                    <p className="text-sm font-medium text-gray-900">Email</p>
                    <p className="text-gray-600">info@thellsol.com</p>
                  </div>
                </div>

                <div className="flex items-start space-x-3">
                  <div className="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mt-1">
                    <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                  </div>
                  <div>
                    <p className="text-sm font-medium text-gray-900">Oficina</p>
                    <p className="text-gray-600">
                      Calle Principal, 123<br />
                      29640 Fuengirola, Málaga<br />
                      España
                    </p>
                  </div>
                </div>

                <div className="flex items-center space-x-3">
                  <div className="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <div>
                    <p className="text-sm font-medium text-gray-900">Horario de Atención</p>
                    <p className="text-gray-600">Lunes a Viernes: 9:00 - 18:00</p>
                    <p className="text-gray-600">Sábados: 10:00 - 14:00</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {/* Formulario de contacto */}
          <div className="bg-white rounded-lg shadow-lg p-8">
            <h3 className="text-2xl font-bold text-gray-900 mb-6">Envíanos un Mensaje</h3>
            
            <form className="space-y-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Nombre *
                  </label>
                  <input
                    type="text"
                    required
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Apellidos *
                  </label>
                  <input
                    type="text"
                    required
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  />
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Email *
                </label>
                <input
                  type="email"
                  required
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Teléfono
                </label>
                <input
                  type="tel"
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Asunto
                </label>
                <select className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                  <option value="">Seleccionar asunto</option>
                  <option value="buy">Comprar propiedad</option>
                  <option value="sell">Vender propiedad</option>
                  <option value="rent">Alquilar propiedad</option>
                  <option value="info">Información general</option>
                  <option value="other">Otro</option>
                </select>
              </div>

              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Mensaje *
                </label>
                <textarea
                  rows={4}
                  required
                  className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Cuéntanos en qué podemos ayudarte..."
                />
              </div>

              <button
                type="submit"
                className="w-full bg-blue-600 text-white py-3 px-6 rounded-md hover:bg-blue-700 transition duration-200 font-medium"
              >
                Enviar Mensaje
              </button>
            </form>
          </div>
        </div>

        {/* Mapa o información adicional */}
        <div className="mt-16">
          <div className="bg-white rounded-lg shadow-lg p-8">
            <h3 className="text-2xl font-bold text-gray-900 mb-6">Nuestra Zona de Actuación</h3>
            <p className="text-gray-600 mb-4">
              ThellSol Real Estate opera en toda la Costa del Sol, con especial atención a:
            </p>
            <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
              <div className="text-center p-4 bg-gray-50 rounded-lg">
                <h4 className="font-semibold text-gray-900">Fuengirola</h4>
                <p className="text-sm text-gray-600">Centro de operaciones</p>
              </div>
              <div className="text-center p-4 bg-gray-50 rounded-lg">
                <h4 className="font-semibold text-gray-900">Mijas</h4>
                <p className="text-sm text-gray-600">Villas y apartamentos</p>
              </div>
              <div className="text-center p-4 bg-gray-50 rounded-lg">
                <h4 className="font-semibold text-gray-900">Marbella</h4>
                <p className="text-sm text-gray-600">Propiedades de lujo</p>
              </div>
              <div className="text-center p-4 bg-gray-50 rounded-lg">
                <h4 className="font-semibold text-gray-900">Benalmádena</h4>
                <p className="text-sm text-gray-600">Primera línea de playa</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
} 
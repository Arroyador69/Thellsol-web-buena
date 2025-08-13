import React from 'react';
import Image from 'next/image';
import Link from 'next/link';

// Función para obtener propiedades desde la API
async function getProperties() {
  try {
    const res = await fetch(`${process.env.NEXT_PUBLIC_BASE_URL || 'http://localhost:3000'}/api/properties`, {
      cache: 'no-store'
    });
    if (!res.ok) throw new Error('Failed to fetch properties');
    return res.json();
  } catch (error) {
    console.error('Error fetching properties:', error);
    return [];
  }
}

export default async function HomePage() {
  // Obtener las propiedades reales de la base de datos
  const properties = await getProperties();
  const featuredProperties = properties.slice(0, 3); // Mostrar solo las 3 primeras

  return (
    <div className="min-h-screen">
      {/* Hero Section */}
      <section className="relative h-[600px] flex items-center justify-center">
        <Image
          src="/images/hero.jpg"
          alt="Costa del Sol"
          fill
          className="object-cover brightness-50"
          priority
        />
        <div className="absolute inset-0 bg-gradient-to-b from-black/50 to-black/30" />
        <div className="relative z-10 text-center text-white px-4">
          <h1 className="text-5xl md:text-6xl font-bold mb-6">ThellSol Real Estate</h1>
          <p className="text-xl md:text-2xl mb-8">Tu hogar en la Costa del Sol</p>
          <div className="flex gap-4 justify-center">
            <Link href="/properties/buy" className="bg-blue-900 text-white px-8 py-3 rounded-lg hover:bg-blue-800 transition">
              Comprar
            </Link>
            <Link href="/properties/sell" className="bg-white text-blue-900 px-8 py-3 rounded-lg hover:bg-gray-100 transition">
              Vender
            </Link>
          </div>
        </div>
      </section>

      {/* About Section */}
      <section className="py-20 bg-white">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row items-center gap-12">
            <div className="md:w-1/2">
              <Image
                src="/images/andre-profile.jpg"
                alt="André Richard Tell"
                width={500}
                height={500}
                className="rounded-lg shadow-xl"
              />
            </div>
            <div className="md:w-1/2">
              <h2 className="text-3xl font-bold text-blue-900 mb-6">Bienvenido a ThellSol Real Estate</h2>
              <p className="text-gray-600 mb-4">
                En ThellSol Real Estate, nos especializamos en hacer realidad tus sueños inmobiliarios en la Costa del Sol. 
                Con años de experiencia y un profundo conocimiento del mercado local, te ofrecemos un servicio personalizado 
                y profesional para encontrar tu hogar perfecto o vender tu propiedad al mejor precio.
              </p>
              <p className="text-gray-600 mb-6">
                Nuestro compromiso es brindarte una experiencia inmobiliaria excepcional, respaldada por la confianza 
                de nuestros clientes y el respaldo legal del prestigioso despacho Martínez-Echevarría.
              </p>
              <Link href="/contact" className="inline-block bg-blue-900 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition">
                Contáctanos
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* Featured Properties */}
      <section className="py-20 bg-gray-50">
        <div className="container mx-auto px-4">
          <h2 className="text-3xl font-bold text-center text-blue-900 mb-12">Propiedades Destacadas</h2>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {featuredProperties.length > 0 ? (
              featuredProperties.map((property: any) => (
                <div key={property.id} className="bg-white rounded-lg shadow-lg overflow-hidden">
                  <div className="relative h-48">
                    <Image
                      src={property.images[0] || "/images/property1.jpg"}
                      alt={property.title}
                      fill
                      className="object-cover"
                    />
                  </div>
                  <div className="p-6">
                    <h3 className="text-xl font-semibold mb-2">{property.title}</h3>
                    <p className="text-gray-600 mb-2">{property.location}</p>
                    <p className="text-gray-600 mb-4">
                      {property.bedrooms} habitaciones · {property.bathrooms} baños · {property.area}m²
                    </p>
                    <p className="text-2xl font-bold text-blue-900 mb-4">
                      {property.price.toLocaleString('es-ES')} €
                    </p>
                    <Link 
                      href={`/properties/${property.id}`} 
                      className="block text-center bg-blue-900 text-white py-2 rounded hover:bg-blue-800 transition"
                    >
                      Ver detalles
                    </Link>
                  </div>
                </div>
              ))
            ) : (
              // Fallback si no hay propiedades
              <>
                <div className="bg-white rounded-lg shadow-lg overflow-hidden">
                  <div className="relative h-48">
                    <Image
                      src="/images/property1.jpg"
                      alt="Apartamento de lujo"
                      fill
                      className="object-cover"
                    />
                  </div>
                  <div className="p-6">
                    <h3 className="text-xl font-semibold mb-2">Apartamento de lujo en el centro</h3>
                    <p className="text-gray-600 mb-2">Centro de la ciudad</p>
                    <p className="text-gray-600 mb-4">2 habitaciones · 2 baños · 110m²</p>
                    <p className="text-2xl font-bold text-blue-900 mb-4">350.000,00 €</p>
                    <Link href="/properties/buy" className="block text-center bg-blue-900 text-white py-2 rounded hover:bg-blue-800 transition">
                      Ver detalles
                    </Link>
                  </div>
                </div>

                <div className="bg-white rounded-lg shadow-lg overflow-hidden">
                  <div className="relative h-48">
                    <Image
                      src="/images/property2.jpg"
                      alt="Villa con piscina"
                      fill
                      className="object-cover"
                    />
                  </div>
                  <div className="p-6">
                    <h3 className="text-xl font-semibold mb-2">Villa con piscina</h3>
                    <p className="text-gray-600 mb-2">Zona residencial</p>
                    <p className="text-gray-600 mb-4">4 habitaciones · 3 baños · 250m²</p>
                    <p className="text-2xl font-bold text-blue-900 mb-4">750.000,00 €</p>
                    <Link href="/properties/buy" className="block text-center bg-blue-900 text-white py-2 rounded hover:bg-blue-800 transition">
                      Ver detalles
                    </Link>
                  </div>
                </div>

                <div className="bg-white rounded-lg shadow-lg overflow-hidden">
                  <div className="relative h-48">
                    <Image
                      src="/images/property3.jpg"
                      alt="Piso con vistas al mar"
                      fill
                      className="object-cover"
                    />
                  </div>
                  <div className="p-6">
                    <h3 className="text-xl font-semibold mb-2">Piso con vistas al mar</h3>
                    <p className="text-gray-600 mb-2">Primera línea de playa</p>
                    <p className="text-gray-600 mb-4">2 habitaciones · 1 baño · 80m²</p>
                    <p className="text-2xl font-bold text-blue-900 mb-4">250.000,00 €</p>
                    <Link href="/properties/buy" className="block text-center bg-blue-900 text-white py-2 rounded hover:bg-blue-800 transition">
                      Ver detalles
                    </Link>
                  </div>
                </div>
              </>
            )}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-20 bg-blue-900 text-white">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-3xl font-bold mb-6">¿Listo para encontrar tu hogar ideal?</h2>
          <p className="text-xl mb-8">Contáctanos hoy mismo y descubre cómo podemos ayudarte</p>
          <Link href="/contact" className="inline-block bg-white text-blue-900 px-8 py-3 rounded-lg hover:bg-gray-100 transition">
            Contactar ahora
          </Link>
        </div>
      </section>
    </div>
  );
} 
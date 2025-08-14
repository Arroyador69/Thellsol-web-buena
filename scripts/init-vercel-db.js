const { PrismaClient } = require('@prisma/client');
const bcrypt = require('bcryptjs');

const prisma = new PrismaClient({
  datasources: {
    db: {
      url: process.env.DATABASE_URL || 'file:./prisma/dev.db'
    }
  }
});

async function main() {
  console.log('🚀 Inicializando base de datos SQLite en Vercel...');

  try {
    // Crear usuario administrador
    const hashedPassword = await bcrypt.hash('admin123', 10);
    
    const adminUser = await prisma.user.upsert({
      where: { email: 'admin@thellsol.com' },
      update: {},
      create: {
        email: 'admin@thellsol.com',
        name: 'Administrador',
        password: hashedPassword,
      },
    });

    console.log('✅ Usuario administrador creado:', adminUser.email);

    // Crear algunas propiedades de ejemplo
    const sampleProperties = [
      {
        title: 'Apartamento de lujo en Fuengirola',
        description: 'Hermoso apartamento con vistas al mar, completamente amueblado y equipado.',
        price: 250000,
        location: 'Fuengirola',
        type: 'apartment',
        bedrooms: 2,
        bathrooms: 2,
        area: 85,
        features: JSON.stringify({
          parking: true,
          pool: true,
          garden: false,
          terrace: true,
          airConditioning: true,
          heating: true,
          elevator: true,
          furnished: true
        }),
        images: JSON.stringify([
          'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800',
          'https://images.unsplash.com/photo-1560448204-603b3fc33ddc?w=800'
        ]),
        status: 'for-sale'
      },
      {
        title: 'Villa con piscina en Marbella',
        description: 'Espectacular villa privada con piscina, jardín y vistas panorámicas.',
        price: 850000,
        location: 'Marbella',
        type: 'villa',
        bedrooms: 4,
        bathrooms: 3,
        area: 250,
        features: JSON.stringify({
          parking: true,
          pool: true,
          garden: true,
          terrace: true,
          airConditioning: true,
          heating: true,
          elevator: false,
          furnished: false
        }),
        images: JSON.stringify([
          'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800',
          'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800'
        ]),
        status: 'for-sale'
      }
    ];

    for (const propertyData of sampleProperties) {
      const property = await prisma.property.create({
        data: propertyData,
      });
      console.log('✅ Propiedad creada:', property.title);
    }

    console.log('🎉 Base de datos inicializada correctamente en Vercel!');
    console.log('');
    console.log('📋 Credenciales de acceso:');
    console.log('   Email: admin@thellsol.com');
    console.log('   Contraseña: admin123');
    console.log('');
    console.log('🌐 URLs:');
    console.log('   Dashboard: https://thellsol.com/admin');
    console.log('   Sitio web: https://thellsol.com');

  } catch (error) {
    console.error('❌ Error inicializando base de datos:', error);
    throw error;
  }
}

main()
  .catch((e) => {
    console.error('❌ Error:', e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });

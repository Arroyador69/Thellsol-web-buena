const { PrismaClient } = require('@prisma/client');
const bcrypt = require('bcryptjs');

const prisma = new PrismaClient();

async function createAdminUser() {
  try {
    console.log('🔧 Creando usuario administrador...');
    
    // Verificar si ya existe un usuario
    const existingUser = await prisma.user.findFirst();
    if (existingUser) {
      console.log('⚠️ Ya existe un usuario en la base de datos');
      console.log('Email:', existingUser.email);
      return;
    }

    // Datos del administrador
    const adminData = {
      name: 'Administrador',
      email: 'admin@thellsol.com',
      password: 'admin123' // Cambiar por una contraseña segura
    };

    // Encriptar contraseña
    const hashedPassword = await bcrypt.hash(adminData.password, 12);

    // Crear usuario
    const user = await prisma.user.create({
      data: {
        name: adminData.name,
        email: adminData.email,
        password: hashedPassword,
      },
    });

    console.log('✅ Usuario administrador creado correctamente');
    console.log('📧 Email:', user.email);
    console.log('🔑 Contraseña:', adminData.password);
    console.log('');
    console.log('⚠️ IMPORTANTE: Cambia la contraseña después del primer inicio de sesión');
    console.log('🔗 Accede a: http://localhost:3000/admin/login');

  } catch (error) {
    console.error('❌ Error al crear usuario administrador:', error);
  } finally {
    await prisma.$disconnect();
  }
}

createAdminUser(); 
import { PrismaClient } from '@prisma/client'

const globalForPrisma = globalThis as unknown as {
  prisma: PrismaClient | undefined
}

export const prisma = globalForPrisma.prisma ?? new PrismaClient({
  datasources: {
    db: {
      url: process.env.DATABASE_URL || 'file:./prisma/dev.db'
    }
  },
  log: ['query', 'info', 'warn', 'error'],
})

if (process.env.NODE_ENV !== 'production') globalForPrisma.prisma = prisma

// Función para obtener todas las propiedades
export async function getAllProperties() {
  try {
    const properties = await prisma.property.findMany({
      where: {
        status: {
          not: 'deleted'
        }
      },
      orderBy: {
        createdAt: 'desc'
      }
    });
    
    return properties.map(property => ({
      ...property,
      features: property.features ? JSON.parse(property.features) : {},
      images: property.images ? JSON.parse(property.images) : []
    }));
  } catch (error) {
    console.error('Error fetching properties:', error);
    return [];
  }
}

// Función para obtener una propiedad por ID
export async function getPropertyById(id: string) {
  try {
    const property = await prisma.property.findFirst({
      where: {
        id,
        status: {
          not: 'deleted'
        }
      }
    });
    
    if (!property) return null;
    
    return {
      ...property,
      features: property.features ? JSON.parse(property.features) : {},
      images: property.images ? JSON.parse(property.images) : []
    };
  } catch (error) {
    console.error('Error fetching property:', error);
    return null;
  }
}

// Función para buscar propiedades con filtros
export async function searchProperties(filters: {
  location?: string;
  type?: string;
  minPrice?: number;
  maxPrice?: number;
  bedrooms?: number;
  bathrooms?: number;
}) {
  try {
    const whereClause: any = {
      status: {
        not: 'deleted'
      }
    };
    
    if (filters.location) {
      whereClause.location = filters.location;
    }
    
    if (filters.type) {
      whereClause.type = filters.type;
    }
    
    if (filters.minPrice || filters.maxPrice) {
      whereClause.price = {};
      if (filters.minPrice) whereClause.price.gte = filters.minPrice;
      if (filters.maxPrice) whereClause.price.lte = filters.maxPrice;
    }
    
    if (filters.bedrooms) {
      whereClause.bedrooms = {
        gte: filters.bedrooms
      };
    }
    
    if (filters.bathrooms) {
      whereClause.bathrooms = {
        gte: filters.bathrooms
      };
    }
    
    const properties = await prisma.property.findMany({
      where: whereClause,
      orderBy: {
        createdAt: 'desc'
      }
    });
    
    return properties.map(property => ({
      ...property,
      features: property.features ? JSON.parse(property.features) : {},
      images: property.images ? JSON.parse(property.images) : []
    }));
  } catch (error) {
    console.error('Error searching properties:', error);
    return [];
  }
}

// Función para crear una nueva propiedad
export async function createProperty(propertyData: {
  title: string;
  description: string;
  price: number;
  location: string;
  type: string;
  bedrooms?: number;
  bathrooms?: number;
  area?: number;
  features: any;
  images: string[];
  status: string;
}) {
  try {
    const property = await prisma.property.create({
      data: {
        title: propertyData.title,
        description: propertyData.description,
        price: propertyData.price,
        location: propertyData.location,
        type: propertyData.type,
        bedrooms: propertyData.bedrooms,
        bathrooms: propertyData.bathrooms,
        area: propertyData.area,
        features: JSON.stringify(propertyData.features),
        images: JSON.stringify(propertyData.images),
        status: propertyData.status
      }
    });
    
    return {
      ...property,
      features: propertyData.features,
      images: propertyData.images
    };
  } catch (error) {
    console.error('Error creating property:', error);
    throw error;
  }
}

// Función para actualizar una propiedad
export async function updateProperty(id: string, propertyData: any) {
  try {
    const property = await prisma.property.update({
      where: { id },
      data: {
        title: propertyData.title,
        description: propertyData.description,
        price: propertyData.price,
        location: propertyData.location,
        type: propertyData.type,
        bedrooms: propertyData.bedrooms,
        bathrooms: propertyData.bathrooms,
        area: propertyData.area,
        features: JSON.stringify(propertyData.features),
        images: JSON.stringify(propertyData.images),
        status: propertyData.status
      }
    });
    
    return {
      ...property,
      features: propertyData.features,
      images: propertyData.images
    };
  } catch (error) {
    console.error('Error updating property:', error);
    throw error;
  }
}

// Función para eliminar una propiedad (soft delete)
export async function deleteProperty(id: string) {
  try {
    await prisma.property.update({
      where: { id },
      data: {
        status: 'deleted'
      }
    });
    
    return { success: true };
  } catch (error) {
    console.error('Error deleting property:', error);
    throw error;
  }
} 
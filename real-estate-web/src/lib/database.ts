import mysql from 'mysql2/promise';

// Configuración de la base de datos existente
const dbConfig = {
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'thellsol_db',
  port: parseInt(process.env.DB_PORT || '3306'),
};

// Pool de conexiones
let pool: mysql.Pool | null = null;

export function getConnection() {
  if (!pool) {
    pool = mysql.createPool(dbConfig);
  }
  return pool;
}

// Función para obtener todas las propiedades
export async function getAllProperties() {
  const connection = getConnection();
  try {
    const [rows] = await connection.execute(`
      SELECT 
        id,
        title,
        description,
        price,
        location,
        type,
        bedrooms,
        bathrooms,
        area,
        features,
        images,
        status,
        created_at,
        updated_at
      FROM properties 
      WHERE status = 'active'
      ORDER BY created_at DESC
    `);
    
    return (rows as any[]).map((row: any) => ({
      id: row.id,
      title: row.title,
      description: row.description,
      price: parseFloat(row.price),
      location: row.location,
      type: row.type,
      bedrooms: row.bedrooms,
      bathrooms: row.bathrooms,
      area: row.area,
      features: row.features ? JSON.parse(row.features) : {},
      images: row.images ? JSON.parse(row.images) : [],
      status: row.status,
      createdAt: row.created_at,
      updatedAt: row.updated_at
    }));
  } catch (error) {
    console.error('Error fetching properties:', error);
    return [];
  }
}

// Función para obtener una propiedad por ID
export async function getPropertyById(id: string) {
  const connection = getConnection();
  try {
    const [rows] = await connection.execute(`
      SELECT 
        id,
        title,
        description,
        price,
        location,
        type,
        bedrooms,
        bathrooms,
        area,
        features,
        images,
        status,
        created_at,
        updated_at
      FROM properties 
      WHERE id = ? AND status = 'active'
    `, [id]);
    
    if ((rows as any[]).length === 0) return null;
    
    const row = (rows as any[])[0];
    return {
      id: row.id,
      title: row.title,
      description: row.description,
      price: parseFloat(row.price),
      location: row.location,
      type: row.type,
      bedrooms: row.bedrooms,
      bathrooms: row.bathrooms,
      area: row.area,
      features: row.features ? JSON.parse(row.features) : {},
      images: row.images ? JSON.parse(row.images) : [],
      status: row.status,
      createdAt: row.created_at,
      updatedAt: row.updated_at
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
  const connection = getConnection();
  try {
    let query = `
      SELECT 
        id,
        title,
        description,
        price,
        location,
        type,
        bedrooms,
        bathrooms,
        area,
        features,
        images,
        status,
        created_at,
        updated_at
      FROM properties 
      WHERE status = 'active'
    `;
    
    const params: any[] = [];
    
    if (filters.location) {
      query += ' AND location = ?';
      params.push(filters.location);
    }
    
    if (filters.type) {
      query += ' AND type = ?';
      params.push(filters.type);
    }
    
    if (filters.minPrice) {
      query += ' AND price >= ?';
      params.push(filters.minPrice);
    }
    
    if (filters.maxPrice) {
      query += ' AND price <= ?';
      params.push(filters.maxPrice);
    }
    
    if (filters.bedrooms) {
      query += ' AND bedrooms >= ?';
      params.push(filters.bedrooms);
    }
    
    if (filters.bathrooms) {
      query += ' AND bathrooms >= ?';
      params.push(filters.bathrooms);
    }
    
    query += ' ORDER BY created_at DESC';
    
    const [rows] = await connection.execute(query, params);
    
    return (rows as any[]).map((row: any) => ({
      id: row.id,
      title: row.title,
      description: row.description,
      price: parseFloat(row.price),
      location: row.location,
      type: row.type,
      bedrooms: row.bedrooms,
      bathrooms: row.bathrooms,
      area: row.area,
      features: row.features ? JSON.parse(row.features) : {},
      images: row.images ? JSON.parse(row.images) : [],
      status: row.status,
      createdAt: row.created_at,
      updatedAt: row.updated_at
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
  const connection = getConnection();
  try {
    const [result] = await connection.execute(`
      INSERT INTO properties (
        title,
        description,
        price,
        location,
        type,
        bedrooms,
        bathrooms,
        area,
        features,
        images,
        status,
        created_at,
        updated_at
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
    `, [
      propertyData.title,
      propertyData.description,
      propertyData.price,
      propertyData.location,
      propertyData.type,
      propertyData.bedrooms || null,
      propertyData.bathrooms || null,
      propertyData.area || null,
      JSON.stringify(propertyData.features),
      JSON.stringify(propertyData.images),
      propertyData.status
    ]);
    
    const insertResult = result as any;
    return {
      id: insertResult.insertId,
      ...propertyData,
      createdAt: new Date(),
      updatedAt: new Date()
    };
  } catch (error) {
    console.error('Error creating property:', error);
    throw error;
  }
}

// Función para actualizar una propiedad
export async function updateProperty(id: string, propertyData: any) {
  const connection = getConnection();
  try {
    await connection.execute(`
      UPDATE properties SET
        title = ?,
        description = ?,
        price = ?,
        location = ?,
        type = ?,
        bedrooms = ?,
        bathrooms = ?,
        area = ?,
        features = ?,
        images = ?,
        status = ?,
        updated_at = NOW()
      WHERE id = ?
    `, [
      propertyData.title,
      propertyData.description,
      propertyData.price,
      propertyData.location,
      propertyData.type,
      propertyData.bedrooms || null,
      propertyData.bathrooms || null,
      propertyData.area || null,
      JSON.stringify(propertyData.features),
      JSON.stringify(propertyData.images),
      propertyData.status,
      id
    ]);
    
    return await getPropertyById(id);
  } catch (error) {
    console.error('Error updating property:', error);
    throw error;
  }
}

// Función para eliminar una propiedad (soft delete)
export async function deleteProperty(id: string) {
  const connection = getConnection();
  try {
    await connection.execute(`
      UPDATE properties SET
        status = 'deleted',
        updated_at = NOW()
      WHERE id = ?
    `, [id]);
    
    return { success: true };
  } catch (error) {
    console.error('Error deleting property:', error);
    throw error;
  }
} 
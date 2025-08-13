import { NextResponse } from 'next/server';
import { getAllProperties } from '@/lib/database';

export async function GET() {
  try {
    const properties = await getAllProperties();
    return NextResponse.json(properties);
  } catch (error) {
    console.error('Error fetching properties:', error);
    return NextResponse.json(
      { error: 'Error al obtener las propiedades' },
      { status: 500 }
    );
  }
} 
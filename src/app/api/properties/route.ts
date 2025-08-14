import { NextResponse } from 'next/server';
import { getAllProperties, createProperty } from '@/lib/database';

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

export async function POST(request: Request) {
  try {
    const body = await request.json();
    const property = await createProperty(body);
    return NextResponse.json(property, { status: 201 });
  } catch (error) {
    console.error('Error creating property:', error);
    return NextResponse.json(
      { error: 'Error al crear la propiedad' },
      { status: 500 }
    );
  }
} 
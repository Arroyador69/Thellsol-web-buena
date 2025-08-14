import { NextResponse } from 'next/server';
import { getPropertyById, updateProperty, deleteProperty } from '@/lib/database';

export async function GET(
  request: Request,
  { params }: { params: { id: string } }
) {
  try {
    const property = await getPropertyById(params.id);
    if (!property) {
      return NextResponse.json(
        { error: 'Propiedad no encontrada' },
        { status: 404 }
      );
    }
    return NextResponse.json(property);
  } catch (error) {
    console.error('Error fetching property:', error);
    return NextResponse.json(
      { error: 'Error al obtener la propiedad' },
      { status: 500 }
    );
  }
}

export async function PUT(
  request: Request,
  { params }: { params: { id: string } }
) {
  try {
    const body = await request.json();
    const property = await updateProperty(params.id, body);
    if (!property) {
      return NextResponse.json(
        { error: 'Propiedad no encontrada' },
        { status: 404 }
      );
    }
    return NextResponse.json(property);
  } catch (error) {
    console.error('Error updating property:', error);
    return NextResponse.json(
      { error: 'Error al actualizar la propiedad' },
      { status: 500 }
    );
  }
}

export async function DELETE(
  request: Request,
  { params }: { params: { id: string } }
) {
  try {
    await deleteProperty(params.id);
    return NextResponse.json({ success: true });
  } catch (error) {
    console.error('Error deleting property:', error);
    return NextResponse.json(
      { error: 'Error al eliminar la propiedad' },
      { status: 500 }
    );
  }
} 
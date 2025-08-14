'use client';

import { useState } from 'react';
import Image from 'next/image';

export default function PropertyDetail({ property }: { property: any }) {
  const [activeImageIndex, setActiveImageIndex] = useState(0);

  return (
    <div className="max-w-4xl mx-auto py-10">
      <h1 className="text-3xl font-bold mb-4">{property.title}</h1>
      <p className="text-lg mb-2 text-gray-600">{property.description}</p>
      <div className="relative w-full h-80 mb-4">
        <Image
          src={property.images[activeImageIndex]}
          alt={property.title}
          fill
          className="object-cover rounded"
        />
      </div>
      <div className="flex space-x-2">
        {property.images.map((img: string, idx: number) => (
          <button
            key={idx}
            className={`w-20 h-20 relative border ${activeImageIndex === idx ? 'border-blue-500' : 'border-transparent'}`}
            onClick={() => setActiveImageIndex(idx)}
          >
            <Image src={img} alt={`thumbnail-${idx}`} fill className="object-cover rounded" />
          </button>
        ))}
      </div>
    </div>
  );
}

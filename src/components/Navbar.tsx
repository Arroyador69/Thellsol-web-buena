'use client';
import React from 'react';
import Link from 'next/link';
import Image from 'next/image';

export default function Navbar() {
  return (
    <nav className="bg-white shadow-lg">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-20">
          <div className="flex items-center">
            <Link href="/" className="flex-shrink-0 flex items-center">
              <Image
                src="/images/logo.png"
                alt="ThellSol Real Estate"
                width={50}
                height={50}
                className="h-12 w-auto"
              />
              <span className="ml-3 text-xl font-semibold text-blue-900">ThellSol Real Estate</span>
            </Link>
          </div>
          
          <div className="hidden md:flex items-center space-x-8">
            <Link href="/" className="text-gray-700 hover:text-blue-900 px-3 py-2 rounded-md text-sm font-medium">
              Inicio
            </Link>
            <div className="relative group">
              <button className="text-gray-700 hover:text-blue-900 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                Propiedades
                <svg className="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              <div className="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block">
                <div className="py-1">
                  <Link href="/properties/buy" className="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                    Comprar
                  </Link>
                  <Link href="/properties/sell" className="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                    Vender
                  </Link>
                </div>
              </div>
            </div>
            <Link href="/informacion-legal" className="text-gray-700 hover:text-blue-900 px-3 py-2 rounded-md text-sm font-medium">
              Información Legal
            </Link>
            <Link href="/contact" className="text-gray-700 hover:text-blue-900 px-3 py-2 rounded-md text-sm font-medium">
              Contacto
            </Link>
          </div>

          {/* Mobile menu button */}
          <div className="md:hidden flex items-center">
            <button className="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
              <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      {/* Mobile menu */}
      <div className="md:hidden hidden">
        <div className="px-2 pt-2 pb-3 space-y-1 sm:px-3">
          <Link href="/" className="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-900 hover:bg-gray-50">
            Inicio
          </Link>
          <Link href="/properties/buy" className="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-900 hover:bg-gray-50">
            Comprar
          </Link>
          <Link href="/properties/sell" className="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-900 hover:bg-gray-50">
            Vender
          </Link>
          <Link href="/informacion-legal" className="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-900 hover:bg-gray-50">
            Información Legal
          </Link>
          <Link href="/contact" className="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-900 hover:bg-gray-50">
            Contacto
          </Link>
        </div>
      </div>
    </nav>
  );
} 
import type { Metadata } from 'next';
import { Inter } from 'next/font/google';
import './globals.css';
import Navbar from '@/components/Navbar';

const inter = Inter({ subsets: ['latin'] });

export const metadata: Metadata = {
  title: 'ThellSol Real Estate - Tu hogar en la Costa del Sol',
  description: 'Encuentra tu hogar ideal en la Costa del Sol con ThellSol Real Estate. Propiedades en venta y alquiler en Fuengirola, Málaga y toda la Costa del Sol.',
};

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="es">
      <body className={inter.className}>
        <Navbar />
        <main>{children}</main>
      </body>
    </html>
  );
}

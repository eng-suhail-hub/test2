import { PropsWithChildren } from 'react'
import { Link } from '@inertiajs/react'

export default function StudentLayout({ children }: PropsWithChildren) {
  return (
    <div dir="rtl" className="min-h-screen bg-gray-50 text-gray-900">
      {/* Header */}
      <header className="bg-white border-b">
        <div className="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
          <Link href="/" className="font-bold text-xl">
            بوابة القبول
          </Link>

          <nav className="flex gap-4 text-sm">
            <Link href="/">الرئيسية</Link>
            <Link href="/universities">الجامعات</Link>
            <Link href="/compare">المقارنة</Link>
          </nav>
        </div>
      </header>

      {/* Content */}
      <main className="max-w-7xl mx-auto px-4 py-8">
        {children}
      </main>
    </div>
  )
}
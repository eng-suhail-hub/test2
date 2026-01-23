import { Head } from '@inertiajs/react'
import StudentLayout from '@/Layouts/StudentLayout'

type Major = {
  id: number
  name: string
}

type College = {
  id: number
  name: string
  majors: Major[]
}

type University = {
  id: number
  name: string
  description?: string
  rating?: number
  colleges: College[]
}

export default function UniversityShow({ university }: { university: University }) {
  return (
    <StudentLayout>
      <Head title={university.name} />

      {/* Header */}
      <section className="bg-white rounded-xl p-6 shadow-sm mb-8">
        <h1 className="text-3xl font-bold text-gray-900">
          {university.name}
        </h1>

        {university.description && (
          <p className="text-gray-600 mt-2 max-w-3xl">
            {university.description}
          </p>
        )}

        {university.rating && (
          <div className="mt-3 flex items-center gap-2 text-sm">
            <span className="text-yellow-500">⭐</span>
            <span className="font-medium">{university.rating}</span>
          </div>
        )}
      </section>

      {/* Colleges & Majors */}
      <section>
        <h2 className="text-xl font-semibold mb-4">
          الكليات والتخصصات
        </h2>

        <div className="space-y-4">
          {university.colleges.map((college) => (
            <div
              key={college.id}
              className="bg-white rounded-lg p-5 shadow-sm"
            >
              <h3 className="font-semibold text-lg mb-3">
                {college.name}
              </h3>

              <div className="flex flex-wrap gap-2">
                {college.majors.map((major) => (
                  <span
                    key={major.id}
                    className="px-3 py-1 text-sm rounded-full bg-gray-100 hover:bg-gray-200 transition"
                  >
                    {major.name}
                  </span>
                ))}
              </div>
            </div>
          ))}
        </div>
      </section>
    </StudentLayout>
  )
}
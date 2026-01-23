import StudentLayout from "@/layouts/StudentLayout";
import { show } from '@/routes/universities';
import Hero from "@/components/home/hero";
import HorizontalList from "@/components/home/HorizontalList";
import { Head } from "@inertiajs/react";

export default function Home({ universities, colleges, majors }: any) {
  return (
    <StudentLayout>
      <Head title="الرئيسية" />

      <Hero />

      <HorizontalList
        title="الجامعات"
        items={universities.map((u:any) => ({
          id: u.id,
          title: u.name,
          subtitle: `⭐ ${u.rating}`,
          href: `${show(u.id)}`,
        }))}
      />

      <HorizontalList
        title="الكليات"
        items={colleges.map((c:any) => ({
          id: c.id,
          title: c.name,
          subtitle: c.university,
          href: `/colleges/${c.id}`,
        }))}
      />

      <HorizontalList
        title="التخصصات"
        items={majors.map((m:any) => ({
          id: m.id,
          title: m.name,
          subtitle: `أقل معدل: ${m.min_gpa}%`,
          href: `/majors/${m.id}`,
        }))}
      />
    </StudentLayout>
  );
}
import { Link } from "@inertiajs/react";
import { Button } from "@/components/ui/button";

export default function Hero() {
  return (
    <section className="bg-white rounded-xl p-8 mb-10 shadow-sm">
      <h1 className="text-3xl font-bold leading-tight">
        التسجيل والقبول الجامعي الإلكتروني
      </h1>
      <p className="text-gray-600 mt-3 max-w-xl">
        قارن بين الجامعات والتخصصات، تحقّق من شروط القبول، وقدّم طلبك بخطوات واضحة.
      </p>

      <div className="mt-6 flex gap-3">
        <Button asChild>
          <Link href="/universities">استكشاف الجامعات</Link>
        </Button>

        <Button variant="outline" asChild>
          <Link href="/compare">المقارنة</Link>
        </Button>
      </div>
    </section>
  );
}
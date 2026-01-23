import { Link } from "@inertiajs/react";

interface Item {
  id: number;
  title: string;
  subtitle?: string;
  href: string;
}

export default function HorizontalList({
  title,
  items,
}: {
  title: string;
  items: Item[];
}) {
  return (
    <section className="mb-10">
      <h2 className="font-semibold text-xl mb-4">{title}</h2>

      <div className="flex gap-4 overflow-x-auto pb-2">
        {items.map(item => (
          <Link
            key={item.id}
            href={item.href}
            className="min-w-[220px] bg-white rounded-lg p-4 shadow-sm hover:shadow transition"
          >
            <div className="font-medium">{item.title}</div>
            {item.subtitle && (
              <div className="text-sm text-gray-500 mt-1">
                {item.subtitle}
              </div>
            )}
          </Link>
        ))}
      </div>
    </section>
  );
}
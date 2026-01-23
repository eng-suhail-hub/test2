export default function Rating({ value, count }: any) {
  return (
    <div className="flex items-center gap-2">
      <span className="text-yellow-500 text-lg">⭐</span>
      <span className="font-medium">{value}</span>
      <span className="text-sm text-gray-500">
        ({count} تقييم)
      </span>
    </div>
  );
}
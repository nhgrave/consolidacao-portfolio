export function formatDateTime(dateString, locale = 'pt-BR') {
  const date = new Date(dateString);

  return new Intl.DateTimeFormat(locale, {
    year: 'numeric',
    month: 'numeric',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
  }).format(date);
}

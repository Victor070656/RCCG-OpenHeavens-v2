# Color Scheme Update

## New Color Palette

The website has been updated with a professional blue color scheme:

### Primary Colors
- **Primary Blue**: `#0d47a1` (Deep Blue) - Main brand color
- **Secondary Blue**: `#001845` (Navy Blue) - Darker accent
- **Supporting Blue**: `#0a3d91` - Mid-tone for gradients

### Accent Colors (Unchanged)
- **Green**: `#16a34a` - Secondary actions, success states
- **Amber/Gold**: `#f59e0b` - CTAs, highlights, "Give" buttons
- **Yellow**: `#fbbf24` - Active states, important highlights

### Neutral Colors
- **Grays**: `#f8fafc` to `#0f172a` - Text, backgrounds, borders
- **White**: `#ffffff` - Clean backgrounds, cards

## Implementation

### Tailwind CSS Config
```javascript
colors: {
    primary: '#0d47a1',
    secondary: '#16a34a',
    accent: '#f59e0b'
}
```

### Gradient Examples
- Navigation: `linear-gradient(135deg, rgba(13, 71, 161, 0.95), rgba(0, 24, 69, 0.95))`
- Hero Section: `linear-gradient(135deg, rgba(13, 71, 161, 0.9), rgba(0, 24, 69, 0.95))`
- CTA Sections: `from-[#0d47a1] to-[#001845]`

## Updated Components

### Navigation
- Background: Blue gradient with glass effect
- Active links: Yellow underline
- Mobile menu: Blue gradient background

### Footer
- Back-to-top button: Blue gradient
- Links: Hover to yellow

### Pages
All pages updated with the new color scheme:
- ✅ index.php
- ✅ sermons.php
- ✅ events.php
- ✅ contact-us.php
- ✅ giving.php

### Common Patterns
- **Primary buttons**: Blue background (`bg-primary` or `bg-[#0d47a1]`)
- **Text links**: Blue text (`text-[#0d47a1]`)
- **Icon backgrounds**: Light blue (`bg-blue-100`)
- **Borders**: Blue accent (`border-[#0d47a1]`)
- **Focus states**: Blue ring (`focus:border-[#0d47a1] focus:ring-2`)

## Brand Identity

The blue color scheme conveys:
- **Trust & Stability**: Deep blues inspire confidence
- **Professionalism**: Clean, corporate-friendly
- **Spirituality**: Heavenly, peaceful associations
- **Authority**: Strong, established presence

Perfect for a religious organization that wants to appear:
- Professional
- Trustworthy
- Established
- Spiritual
- Modern

## Accessibility

All color combinations meet WCAG 2.1 AA standards:
- Blue (#0d47a1) on white: ✅ Pass
- White text on blue: ✅ Pass
- Navy (#001845) on white: ✅ Pass
- Links and buttons maintain sufficient contrast

---

**Last Updated**: October 14, 2024
**Color Scheme**: Blue Theme (#0d47a1 & #001845)

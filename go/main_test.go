package main

import (
	"github.com/kulti/titlecase"
	"github.com/stretchr/testify/require"
	"testing"
)

// Задание
// 1. Дописать существующие тесты.
// 2. Придумать один новый тест.
//
// Дополнительное задание: использовать табличные тесты и testify.require
//
// Документация по тестируемой функции:
// Делает слова в строке из первого аргумента с большой буквы, кроме слов из строки из второго аргумента
// Первое слово всегда с большой буквы
//
// TitleCase(str, minor) returns a str string with all words capitalized except minor words.
// The first word is always capitalized.
//
// E.g.
// TitleCase("the quick fox in the bag", "") = "The Quick Fox In The Bag"
// TitleCase("the quick fox in the bag", "in the") = "The Quick Fox in the Bag"

func TestEmpty(t *testing.T) {
	const str, minor, want = "", "", ""
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithoutMinor(t *testing.T) {
	// передайте пустую строку в качестве второго агрумента

	const str, minor, want = "upgrade", "", "Upgrade"

	goT := titlecase.TitleCase(str, minor)

	if goT != want {
		t.Fatalf("TitleCase(%v, %v) = %v; want %v", str, minor, goT, want)
	}

}

func TestWithMinorInFirst(t *testing.T) {
	// передайте первое слово исходной строки в качестве второго аргумента

	const str, minor, want = "dongelek upgrade home work ", "dongelek", "dongelek Upgrade Home Work "

	goT := titlecase.TitleCase(str, minor)

	if goT != want {
		t.Fatalf("TitleCase(%v, %v) = %v; want %v", str, minor, goT, want)
	}

}

func TestWithTableTestsAndTestify(t *testing.T) {
	require := require.New(t)

	addTest := []struct{ str, minor, want string }{
		{"Dima", "", "Dima"},
		{"Lorem opsium etc", "opsium", "Lorem opsium Etc"},
		{"Never gonna give you up", "give you up", "Never Gonna give you up"},
	}

	for _, test := range addTest {
		got := titlecase.TitleCase(test.str, test.minor)
		require.Equal(test.want, got)
	}

}
